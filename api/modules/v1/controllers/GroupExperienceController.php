<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\GroupExperience;
use common\models\search\GroupExperienceSearch;

class GroupExperienceController extends BaseController
{
    public $modelClass = GroupExperience::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new GroupExperienceSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}