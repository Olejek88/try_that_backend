<?php

namespace api\components;

use common\components\BaseRecord;
use yii\filters\auth\HttpBearerAuth;
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
        $behaviors['authenticator']['class'] = HttpBearerAuth::class;
        $behaviors['authenticator']['except'] = [
            'index', 'view',
        ];
        return $behaviors;
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
