<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Customer;
use common\models\search\CustomerSearch;

class CustomerController extends BaseController
{
    public $modelClass = Customer::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = [];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new CustomerSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}