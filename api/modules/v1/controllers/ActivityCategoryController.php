<?php

namespace api\modules\v1\controllers;

use common\models\ActivityCategory;
use yii\rest\ActiveController;

class ActivityCategoryController extends ActiveController
{
    public $modelClass = ActivityCategory::class;
}