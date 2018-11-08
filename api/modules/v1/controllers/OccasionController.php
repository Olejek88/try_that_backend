<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Occasion;

class OccasionController extends BaseController
{
    public $modelClass = Occasion::class;
}
