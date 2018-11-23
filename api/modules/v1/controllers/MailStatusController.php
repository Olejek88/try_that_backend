<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\MailStatus;
use common\models\search\MailStatusSearch;

class MailStatusController extends BaseController
{
    public $modelClass = MailStatus::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new MailStatusSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
