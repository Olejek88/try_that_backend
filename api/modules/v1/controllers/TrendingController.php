<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Trending;

class TrendingController extends BaseController
{
    public $modelClass = Trending::class;
}
