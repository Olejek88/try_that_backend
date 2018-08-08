<?php

namespace api\modules\v1\controllers;

use yii\base\Module;
use yii\rest\Controller;

/**
 * Site controller
 */
class PayController extends Controller
{

    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

    }

    public function actionIndex()
    {
//        Url::to(['v1/controllers/pay/index', 'id' => 666]);
        return ['message' => 'index pay page'];
    }

    public function actionConfirm()
    {
//        Url::to(['v1/controllers/pay/index', 'id' => 666]);
        \Yii::warning($_POST, 'application');
        return ['message' => 'confirm page'];
    }

    public function actionInfo()
    {
//        Url::to(['v1/controllers/pay/index', 'id' => 666]);
        \Yii::warning($_POST, 'application');
        return ['message' => 'confirm page'];
    }

    public function actionBackUrl()
    {
//        Url::to(['v1/controllers/pay/index', 'id' => 666]);
//        \Yii::warning($_POST, 'application');
        return ['message' => 'back url page'];
    }
}
