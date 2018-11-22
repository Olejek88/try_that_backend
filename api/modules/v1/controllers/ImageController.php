<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Image;
use common\models\search\ImageSearch;

class ImageController extends BaseController
{
    public $modelClass = Image::class;
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ImageSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
