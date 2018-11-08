<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Activity;

class ActivityController extends BaseController
{
    public $modelClass = Activity::class;
}