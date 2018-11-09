<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ActivityTag;

class ActivityTagController extends BaseController
{
    public $modelClass = ActivityTag::class;
}