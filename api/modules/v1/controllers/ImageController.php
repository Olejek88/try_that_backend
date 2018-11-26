<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Image;
use common\models\search\ImageSearch;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\Security;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;


class ImageController extends BaseController
{
    public $modelClass = Image::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ImageSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

    /**
     * @return Image
     * @throws InvalidArgumentException
     * @throws ServerErrorHttpException
     * @throws Exception
     */
    public function actionCreate()
    {
        $image = UploadedFile::getInstanceByName('image');
        if (empty($image)) {
            throw new InvalidArgumentException();
        }

        $title = \Yii::$app->request->getBodyParam('title', '');

        $storage = \Yii::getAlias('@storage');
        $storagePath = \Yii::getAlias('@storagePath');

        $uploadPath = '/uploads';
        $dir = $storagePath . $uploadPath;
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true)) {
                throw new ServerErrorHttpException();
            }
        }

        $sec = new Security();
        $fileName = $sec->generateRandomString() . '.' . $image->extension;
        $path = $storagePath . $uploadPath . '/' . $fileName;
        if (!$image->saveAs($path)) {
            throw new ServerErrorHttpException();
        }

        $imageModel = new Image();
        $imageModel->title = $title;
        $imageModel->path = $storage . $uploadPath . '/' . $fileName;
        $imageModel->user_id = \Yii::$app->user->id;
        if ($imageModel->save()) {
            return $imageModel;
        }

        throw new InvalidArgumentException();
    }
}
