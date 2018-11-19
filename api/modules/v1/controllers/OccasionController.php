<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Occasion;
use common\models\search\OccasionSearch;

class OccasionController extends BaseController
{
    public $modelClass = Occasion::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new OccasionSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
