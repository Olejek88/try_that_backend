<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\search\UserAttributeSearch;
use common\models\UserAttribute;

class UserAttributeController extends BaseController
{
    public $modelClass = UserAttribute::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new UserAttributeSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
