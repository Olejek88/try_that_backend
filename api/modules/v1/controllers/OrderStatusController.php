<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\OrderStatus;

class OrderStatusController extends BaseController
{
    public $modelClass = OrderStatus::class;
}
