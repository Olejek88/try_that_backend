<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Order;

class OrderController extends BaseController
{
    public $modelClass = Order::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }
}
