<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Tag;

class TagController extends BaseController
{
    public $modelClass = Tag::class;
}