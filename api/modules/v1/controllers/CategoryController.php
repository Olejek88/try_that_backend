<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Category;

class CategoryController extends BaseController
{
    var $modelClass = Category::class;
}