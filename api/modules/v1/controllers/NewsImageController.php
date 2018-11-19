<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\NewsImage;
use common\models\search\NewsImageSearch;

class NewsImageController extends BaseController
{
    public $modelClass = NewsImage::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new NewsImageSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
