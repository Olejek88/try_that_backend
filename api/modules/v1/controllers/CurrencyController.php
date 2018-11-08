<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Currency;

class CurrencyController extends BaseController
{
    var $modelClass = Currency::class;
}