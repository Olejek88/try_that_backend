<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\components\BaseRecord;
use common\models\User;

class UserController extends BaseController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $rules = &$behaviors['access']['rules'];
        $rules[] = [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['admin', 'customer', 'luminary'],
            'matchCallback' => function (
                /** @noinspection PhpUnusedParameterInspection */
                $rule,
                $action
            ) {
                /* @var BaseRecord $modelClass */
                $modelClass = $this->modelClass;
                /* @var BaseRecord $model */
                $model = $modelClass::findOne(\Yii::$app->request->get('id'));
                $modelPermissions = $model->getPermissions();
                if (\Yii::$app->user->can($modelPermissions[$action->id], ['User' => $model])) {
                    return true;
                }

                return false;
            },
        ];

        return $behaviors;
    }
}