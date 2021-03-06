<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\search\TagSearch;
use common\models\Tag;

class TagController extends BaseController
{
    public $modelClass = Tag::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new TagSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}