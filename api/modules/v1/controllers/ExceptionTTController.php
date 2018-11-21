<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ExceptionTT;
use common\models\search\ExceptionTTSearch;

class ExceptionTTController extends BaseController
{
    public $modelClass = ExceptionTT::class;
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ExceptionTTSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}