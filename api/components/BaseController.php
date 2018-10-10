<?php

namespace api\components;

use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

/**
 * Базовый класс с авторизацией для "простых" контроллеров проекта.
 */
class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::class;

        return $behaviors;
    }
}
