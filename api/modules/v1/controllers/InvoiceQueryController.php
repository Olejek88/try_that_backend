<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\InvoiceQuery;

class InvoiceQueryController extends BaseController
{
    public $modelClass = InvoiceQuery::class;
}
