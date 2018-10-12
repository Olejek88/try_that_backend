<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Review;

class ReviewController extends BaseController
{
    public $modelClass = Review::class;
}
