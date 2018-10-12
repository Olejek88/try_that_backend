<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\UserImage;

class UserImageController extends BaseController
{
    public $modelClass = UserImage::class;
}
