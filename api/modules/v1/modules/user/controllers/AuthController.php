<?php

namespace api\modules\v1\modules\user\controllers;

use api\models\form\LoginForm;
use yii\filters\Cors;
use yii\rest\Controller;

class AuthController extends Controller
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
            ]
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
     * @return LoginForm|array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRequest()
    {
        $model = new LoginForm();
        $model->load(\Yii::$app->request->bodyParams, '');
        if ($model->validate()) {
            $user = $model->getUser();
            $token = $user->generateAccessToken(60 * 60 * 24 * 7);
            $user->save();
            return [
                'token' => $token,
                'id' => $user->id
            ];
        } else {
            return $model;
        }
    }

}
