<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ActivityCategory;
use common\models\search\ActivityCategorySearch;

class ActivityCategoryController extends BaseController
{
    public $modelClass = ActivityCategory::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ActivityCategorySearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}