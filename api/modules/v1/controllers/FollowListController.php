<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\FollowList;

class FollowListController extends BaseController
{
    public $modelClass = FollowList::class;
}