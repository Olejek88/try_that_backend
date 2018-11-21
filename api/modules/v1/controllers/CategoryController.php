<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Category;
use common\models\search\CategorySearch;

class CategoryController extends BaseController
{
    var $modelClass = Category::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new CategorySearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}