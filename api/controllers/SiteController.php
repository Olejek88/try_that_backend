<?php

namespace api\controllers;

/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return ['message' => 'home page'];
    }
}
