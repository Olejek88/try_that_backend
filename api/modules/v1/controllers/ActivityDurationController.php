<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ActivityDuration;
use common\models\search\ActivityDurationSearch;

class ActivityDurationController extends BaseController
{
    public $modelClass = ActivityDuration::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ActivityDurationSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}