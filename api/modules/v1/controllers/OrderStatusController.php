<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\OrderStatus;
use common\models\search\OrderStatusSearch;

class OrderStatusController extends BaseController
{
    public $modelClass = OrderStatus::class;

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
        $searchModel = new OrderStatusSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
