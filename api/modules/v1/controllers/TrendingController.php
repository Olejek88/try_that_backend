<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\search\TrendingSearch;
use common\models\Trending;

class TrendingController extends BaseController
{
    public $modelClass = Trending::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new TrendingSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
