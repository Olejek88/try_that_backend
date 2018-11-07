<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Image;

class ImageController extends BaseController
{
    public $modelClass = Image::class;
}
