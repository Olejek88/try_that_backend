<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\search\WishlistSearch;
use common\models\Wishlist;

class WishlistController extends BaseController
{
    public $modelClass = Wishlist::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new WishlistSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
