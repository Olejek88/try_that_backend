<?php

namespace api\components;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
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
            'index', 'view',
        ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['options', 'upload'],
                    'roles' => ['admin', 'customer', 'luminary'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'view'],
                    'roles' => [],
                ],
            ]
        ];

        return $behaviors;
    }
}
