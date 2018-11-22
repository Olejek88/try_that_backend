<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ActivityImage;
use common\models\search\ActivityImageSearch;

class ActivityImageController extends BaseController
{
    public $modelClass = ActivityImage::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ActivityImageSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}