<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\News;
use common\models\search\NewsSearch;

class NewsController extends BaseController
{
    public $modelClass = News::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new NewsSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
