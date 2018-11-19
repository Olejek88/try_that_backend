<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Duration;
use common\models\search\DurationSearch;

class DurationController extends BaseController
{
    public $modelClass = Duration::class;
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new DurationSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}