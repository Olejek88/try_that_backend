<?php

namespace api\modules\v1\controllers;

use common\models\Country;
use yii\rest\ActiveController;

class CountryController extends ActiveController
{
    public $modelClass = Country::class;
}