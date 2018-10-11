<?php

namespace api\modules\v1\modules\user\controllers;

use api\models\form\SignupForm;
use api\models\User;
use Yii;
use yii\rest\Controller;

/**
 * Class SignupController
 * @package api\modules\v1\modules\user\controllers
 */
class SignupController extends Controller
{
    /**
     * @inheritdoc
     */
    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['request'] = ['post'];
        return $verbs;
    }

    /**
     * @return User|SignupForm
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function actionRequest()
    {
        $form = new SignupForm();
        $request = \Yii::$app->getRequest()->getBodyParams();
        if ($form->load($request, '') && $form->validate()) {
            try {
                return User::requestSignup($form->email, $form->password);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                $form->addError('ALL', 'DomainException: Unknown error');
            }
        }

        return $form;
    }
}
