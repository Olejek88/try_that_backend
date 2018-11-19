<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\search\UserSearch;
use common\models\User;

class UserController extends BaseController
{
    public $modelClass = User::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new UserSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}