<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\City;

class CityController extends BaseController
{
    public $modelClass = City::class;
}