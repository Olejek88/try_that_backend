<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\UserAttribute;

class UserAttributeController extends BaseController
{
    public $modelClass = UserAttribute::class;
}
