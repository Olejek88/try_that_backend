<?php

namespace api\modules\v1\modules\user;

/**
 * Class RequestController
 * @package api\modules\v1\modules\user
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

    public function actionSignUp()
    {
        return ['message' => 'SignUp Page'];
    }
}
