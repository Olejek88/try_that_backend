<?php

namespace api\components;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

/**
 * Базовый класс с авторизацией для "простых" контроллеров проекта.
 */
class BaseController extends ActiveController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::class;
        $behaviors['authenticator']['except'] = [
            'index', 'view', 'options'
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost', 'http://localhost:3000'],
                //'Access-Control-Request-Method' => ['POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['X-File-Upload', 'content-type', 'Authorization'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['upload'],
                    'roles' => ['admin', 'customer', 'luminary'],
                ],
                [
                    'allow' => true,
                    'actions' => ['options','index', 'view'],
                    'roles' => [],
                ],
            ]
        ];

        return $behaviors;
    }
}
