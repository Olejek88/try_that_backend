<?php

namespace api\modules\v1\modules\user\controllers;

use api\models\form\SignupForm;
use api\models\User;
use Yii;
use yii\filters\Cors;
use yii\rest\Controller;

/**
 * Class SignupController
 * @package api\modules\v1\modules\user\controllers
 */
class SignupController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost', 'http://localhost:3000'],
                'Access-Control-Request-Method' => ['POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['Authorization','content-type'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['request'] = ['POST', 'OPTIONS'];
        return $verbs;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['options'] = [
            'class' => 'yii\rest\OptionsAction',
        ];
        return $actions;
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
