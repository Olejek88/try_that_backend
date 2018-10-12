<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Customer;

class CustomerController extends BaseController
{
    public $modelClass = Customer::class;
}