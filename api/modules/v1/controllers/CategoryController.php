<?php

namespace api\modules\v1\controllers;

use common\models\Category;
use yii\rest\ActiveController;

class CategoryController extends ActiveController
{
    var $modelClass = Category::class;
}