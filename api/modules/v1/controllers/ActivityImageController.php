<?php

namespace api\modules\v1\controllers;

use common\models\ActivityImage;
use yii\rest\ActiveController;

class ActivityImageController extends ActiveController
{
    public $modelClass = ActivityImage::class;
}