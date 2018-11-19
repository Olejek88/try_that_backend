<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Review;
use common\models\search\ReviewSearch;

class ReviewController extends BaseController
{
    public $modelClass = Review::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ReviewSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
