<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\models\Image;
use common\models\News;
use common\models\NewsImage;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\Security;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class NewsController extends BaseController
{
    public $modelClass = News::class;

    /**
     * @param $newsId
     * @return Image
     * @throws InvalidArgumentException
     * @throws ServerErrorHttpException
     * @throws Exception
     */
    public function actionUpload($newsId)
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
            $newsImage = new NewsImage();
            $newsImage->news_id = $newsId;
            $newsImage->image_id = $imageModel->id;
            if ($newsImage->save()) {
                return $imageModel;
            }
        }

        throw new InvalidArgumentException();
    }
}
