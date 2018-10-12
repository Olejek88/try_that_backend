<?php

namespace api\modules\v1\controllers;

use common\models\ActivityDuration;
use yii\rest\ActiveController;

class ActivityDurationController extends ActiveController
{
    public $modelClass = ActivityDuration::class;
}