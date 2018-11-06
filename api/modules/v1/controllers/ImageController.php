<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\UserImage;

class ImageController extends BaseController
{
    public $modelClass = UserImage::class;
}
