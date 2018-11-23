<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Order;
use common\models\search\OrderSearch;

class OrderController extends BaseController
{
    public $modelClass = Order::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options'];
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
        $searchModel = new OrderSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
