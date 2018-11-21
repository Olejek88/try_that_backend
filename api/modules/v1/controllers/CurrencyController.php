<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Currency;
use common\models\search\CurrencySearch;

class CurrencyController extends BaseController
{
    var $modelClass = Currency::class;
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new CurrencySearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}