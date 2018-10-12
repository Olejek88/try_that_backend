<?php

namespace api\modules\v1\controllers;

use common\models\Activity;
use yii\rest\ActiveController;

class ActivityController extends ActiveController
{
    public $modelClass = Activity::class;
}