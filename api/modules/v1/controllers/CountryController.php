<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Country;

class CountryController extends BaseController
{
    public $modelClass = Country::class;
}