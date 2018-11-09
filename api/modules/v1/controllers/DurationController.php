<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Duration;

class DurationController extends BaseController
{
    public $modelClass = Duration::class;
}