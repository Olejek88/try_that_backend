<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\MailStatus;

class MailStatusController extends BaseController
{
    public $modelClass = MailStatus::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = [];
        return $behaviors;
    }
}
