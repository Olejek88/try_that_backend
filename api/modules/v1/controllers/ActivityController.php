<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Activity;
use common\models\search\ActivitySearch;

class ActivityController extends BaseController
{
    public $modelClass = Activity::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ActivitySearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}