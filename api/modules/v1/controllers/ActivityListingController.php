<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ActivityListing;
use common\models\search\ActivityListingSearch;

class ActivityListingController extends BaseController
{
    public $modelClass = ActivityListing::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ActivityListingSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}