<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ActivityTag;
use common\models\search\ActivityTagSearch;

class ActivityTagController extends BaseController
{
    public $modelClass = ActivityTag::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ActivityTagSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}