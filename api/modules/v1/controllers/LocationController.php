<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Location;
use common\models\search\LocationSearch;

class LocationController extends BaseController
{
    public $modelClass = Location::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new LocationSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
