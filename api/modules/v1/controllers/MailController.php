<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Mail;

class MailController extends BaseController
{
    public $modelClass = Mail::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = [];
        return $behaviors;
    }
}
