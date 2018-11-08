<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Location;

class LocationController extends BaseController
{
    public $modelClass = Location::class;
}
