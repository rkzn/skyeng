Test app for skyeng
===================

Instructions to run the app:

* clone project
* create MySQL database for app and fill parameters in app/config/parameters.yml 
* run `composer install`
* run `php app/console doctrine:migrations:migrate`
* run `php app/console server:run 127.0.0.1:8001`
* open http://127.0.0.1:8001/app_dev.php/ in your browser