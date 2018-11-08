<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Luminary;

class LuminaryController extends BaseController
{
    public $modelClass = Luminary::class;
}
