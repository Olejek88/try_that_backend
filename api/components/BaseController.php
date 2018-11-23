<?php

namespace api\components;

use common\components\BaseRecord;
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
            'index',
            'view',
            'options'
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost', 'http://localhost:3000'],
                'Access-Control-Request-Headers' => ['authorization', 'content-type'],
                'Access-Control-Allow-Credentials' => true,
            ]
        ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view'],
                    'roles' => [],
                ],
            ]
        ];
        $behaviors['access']['rules']['baseRules'] = [
            'allow' => true,
            'matchCallback' => function (
                /** @noinspection PhpUnusedParameterInspection */
                $rule,
                $action
            ) {
                /* @var BaseRecord $modelClass */
                $modelClass = $this->modelClass;
                /* @var BaseRecord $model */
                $model = new $modelClass;
                $modelPermissions = $model->getPermissions();
                if (isset($modelPermissions[$action->id])) {
                    $params = $model->getRuleParams($action->id);
                    if (\Yii::$app->user->can($modelPermissions[$action->id], $params)) {
                        return true;
                    }
                }

                return false;
            },
        ];

        return $behaviors;
    }
}
