<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Luminary;
use common\models\search\LuminarySearch;

class LuminaryController extends BaseController
{
    public $modelClass = Luminary::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new LuminarySearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
