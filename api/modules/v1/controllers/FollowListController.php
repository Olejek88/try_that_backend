<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\FollowList;
use common\models\search\FollowListSearch;

class FollowListController extends BaseController
{
    public $modelClass = FollowList::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new FollowListSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}