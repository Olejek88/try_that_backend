<?php

namespace api\components;

use common\components\BaseRecord;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

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
/*        $behaviors['authenticator']['class'] = HttpBearerAuth::class;
        $behaviors['authenticator']['except'] = [
            'index', 'view',
        ];*/
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
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
        $verbs['request'] = ['GET', 'POST', 'OPTIONS'];
        return $verbs;
    }

    /**
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws \yii\web\ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if (in_array($action, ['index', 'view'])) {
            return;
        }

        /* @var BaseRecord $modelObj */
        $modelObj = new $this->modelClass;
        $permissions = $modelObj->getPermissions();

        // проверяем "базовые" права доступа
        if (\Yii::$app->user->can($permissions[$action])) {
            return;
        }

        // проверяем "расширенные" права доступа
        $suffixes = ['Owner', 'ParentOwner'];
        foreach ($suffixes as $suffix) {
            if (\Yii::$app->user->can($permissions[$action] . $suffix)) {
                return;
            }
        }

        throw new ForbiddenHttpException('You can not access to that object.');
    }

}
