<?php

namespace api\controllers;

/**
 * Class RequestController
 * @package api\controllers
 */
class RequestController extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['sign-up'] = $verbs['sign-in'] = ['POST', 'OPTIONS'];
        return $verbs;
    }

    // @todo[msdev]: Реализовать регистрацию
    public function actionSignUp()
    {
        return ['message' => 'SignUp Page'];
    }

    // @todo[msdev]: Реализовать авторизацию
    public function actionSignIn()
    {
        return ['message' => 'SignIn Page'];
    }
}
