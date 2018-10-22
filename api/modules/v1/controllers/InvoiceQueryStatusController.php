<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\InvoiceQueryStatus;

class InvoiceQueryStatusController extends BaseController
{
    public $modelClass = InvoiceQueryStatus::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = [];
        return $behaviors;
    }
}
