<?php

namespace api\modules\v1\controllers;

use common\models\ActivityListing;
use yii\rest\ActiveController;

class ActivityListingController extends ActiveController
{
    public $modelClass = ActivityListing::class;
}