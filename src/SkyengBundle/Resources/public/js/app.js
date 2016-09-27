(function () {
    angular.module('Skyeng', []).controller('DictionaryController', ['$scope', '$http', function ($scope, $http) {
        this.setUser = function() {
            if ($scope.username) {
                $scope.start();
            }
        }
        $scope.start = function() {
            $scope.offset = 0;
            $scope.inProgress = true;
            $scope.isOver = false;
            $scope.points = 0;
            $scope.errors = 0;
            $scope.getQuestion();
            $scope.answer = false;

        };

        $scope.$watch('errors', function(newValue, oldValue) {
            if (newValue == 3) {
                $scope.showResults();
            }
        }, true);

        $scope.getQuestion = function() {
            $('#currentQuestion').removeClass('panel-danger');
            var req = {
                method: 'GET',
                url: Routing.generate('skyeng_get_question'),
                params: { 'offset': $scope.offset }
            };
            $http(req).success(function (data) {
                if (data.question) {
                    $scope.questionReady = true;
                    $scope.question = data.question;
                    $scope.options = data.options;
                    $scope.translateTo = data.translateTo;
                } else {
                    $scope.showResults();
                }
            });
        };

        $scope.checkAnswer = function() {
            var $input = $('#currentQuestion').find('input[name="answer"]:checked');
            if (!$input.length) {
                return;
            }
            var answer = $input.val();
            var req = {
                method: 'POST',
                url: Routing.generate('skyeng_check_answer'),
                params: {
                    offset: $scope.offset,
                    answer: answer,
                    translateTo: $scope.translateTo
                }
            };

            $http(req).success(function (data) {
                var isCorrect = data.isCorrect;
                $scope.answer = false;

                if (!isCorrect) {
                    $scope.errors += 1;
                    $('#currentQuestion').addClass('panel-danger');
                    $input.parent('.list-group-item')
                } else {
                    $scope.offset += 1;
                    $scope.points += 1;
                    $scope.getQuestion();
                }
            });
        };

        $scope.showResults = function () {
            $scope.isOver = true;

            var req = {
                method: 'POST',
                url: Routing.generate('skyeng_save_result'),
                params: {
                    username: $scope.username,
                    points: $scope.points,
                    errors: $scope.errors
                }
            };

            $http(req);
        }
    }]);
})();