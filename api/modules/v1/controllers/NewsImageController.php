<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\NewsImage;

class NewsImageController extends BaseController
{
    public $modelClass = NewsImage::class;
}
