<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Country;
use common\models\search\CountrySearch;

class CountryController extends BaseController
{
    public $modelClass = Country::class;
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new CountrySearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}