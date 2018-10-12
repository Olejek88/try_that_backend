<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\News;

class NewsController extends BaseController
{
    public $modelClass = News::class;
}
