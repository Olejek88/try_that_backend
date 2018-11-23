<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\User;

class UserController extends BaseController
{
    public $modelClass = User::class;
}