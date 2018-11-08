<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ActivityCategory;

class ActivityCategoryController extends BaseController
{
    public $modelClass = ActivityCategory::class;
}