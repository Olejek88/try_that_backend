<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Mail;
use common\models\search\MailSearch;

class MailController extends BaseController
{
    public $modelClass = Mail::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = [];
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
        $searchModel = new MailSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
