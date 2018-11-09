<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\ActivityListing;

class ActivityListingController extends BaseController
{
    public $modelClass = ActivityListing::class;
}