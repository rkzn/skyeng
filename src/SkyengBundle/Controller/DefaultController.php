<?php

namespace SkyengBundle\Controller;

use SkyengBundle\Entity\Error;
use SkyengBundle\Entity\Result;
use SkyengBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    const COUNT_QUESTIONS = 10;
    const OFFSET_IDS = 'offset_ids';
    const EN = 'eng';
    const RU = 'rus';

    public function indexAction()
    {
        return $this->render('SkyengBundle:Default:index.html.twig');
    }

    public function questionAction(Request $request)
    {
        $offset = $request->get('offset');
        $repo = $this->getDoctrine()->getRepository('SkyengBundle:Word');
        $word = $this->getWordByOffset($offset);

        if ($word) {
            $translateOptions = [self::EN, self::RU];
            $translateRand = array_rand($translateOptions);
            $translateTo = $translateOptions[$translateRand];
            $options = $repo->getRandomTranslateOptions($word->getId(), $translateTo);

            if ($translateTo == self::RU) {
                $question = $word->getEng();
                $options[] = $word->getRus();
            } else {
                $question = $word->getRus();
                $options[] = $word->getEng();
            }
            shuffle($options);
            $response = [
                'question' => $question,
                'options' => $options,
                'translateTo' => $translateTo
            ];
        } else {
            $response = [
                'question' => false
            ];
        }

        return new JsonResponse($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkAnswerAction(Request $request)
    {
        $translateTo = $request->get('translateTo');
        $answer = $request->get('answer');
        $word = $this->getWordByOffset($request->get('offset'));
        $isCorrect = false;

        if ($translateTo == self::RU && $word->getRus() == $answer) {
            $isCorrect = true;
        }

        if ($translateTo == self::EN && $word->getEng() == $answer) {
            $isCorrect = true;
        }

        if (!$isCorrect) {
            $em = $this->getDoctrine()->getManager();
            $error = $em->getRepository('SkyengBundle:Error')->findByWordAndAswer($word, $answer);
            $error->setQuantity($error->getQuantity() + 1);
            $em->persist($error);
            $em->flush();
        }
        return new JsonResponse([
            'isCorrect' => $isCorrect
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAction(Request $request)
    {
        $username = $request->get('username');
        $points = $request->get('points');
        $errors = $request->get('errors');
        $result = new Result();
        $result->setUsername($username);
        $result->setPoints($points);
        $result->setErrors($errors);
        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();

        return new JsonResponse([
            'success' => true
        ]);
    }

    /**
     * @param $offset
     *
     * @return bool|Word
     */
    protected function getWordByOffset($offset)
    {
        $session = $this->get('session');
        $repo = $this->getDoctrine()->getRepository('SkyengBundle:Word');
        if ($session->has(self::OFFSET_IDS) == false) {
            $session->set(self::OFFSET_IDS, $repo->getRandomIds(self::COUNT_QUESTIONS));
        }

        $ids = $session->get(self::OFFSET_IDS, []);

        if (array_key_exists($offset, $ids)) {
            return $repo->findOneById($ids[$offset]);
        } else {
            return null;
        }
    }
}
