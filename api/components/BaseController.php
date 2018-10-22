<?php

namespace api\components;

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
        return $behaviors;
    }
}
