<?php

namespace api\modules\v1\controllers;

use api\components\BaseController;
use common\components\BaseRecord;
use common\models\Image;
use common\models\User;
use yii\web\UploadedFile;

class UserController extends BaseController
{
    public $modelClass = User::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $rules = &$behaviors['access']['rules'];
        $rules[] = [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['admin', 'customer', 'luminary'],
            'matchCallback' => function (
                /** @noinspection PhpUnusedParameterInspection */
                $rule,
                $action
            ) {
                /* @var BaseRecord $modelClass */
                $modelClass = $this->modelClass;
                /* @var BaseRecord $model */
                $model = $modelClass::findOne(\Yii::$app->request->get('id'));
                $modelPermissions = $model->getPermissions();
                if (\Yii::$app->user->can($modelPermissions[$action->id], ['User' => $model])) {
                    return true;
                }

                return false;
            },
        ];

        return $behaviors;
    }

    public function actionUpload()
    {
        $image = UploadedFile::getInstanceByName('image');
        if (empty($image)) {
            return 'Must upload at least 1 file in upfile form-data POST';
        }

        $title = \Yii::$app->request->getBodyParam('title', '');

        $path = '/tmp/uploadFile';
        $image->saveAs($path); //Your uploaded file is saved, you can process it further from here

        $imageModel = new Image();
        $imageModel->title = $title;
        $imageModel->path = $path;
        $imageModel->user_id = \Yii::$app->user->id;
        $imageModel->save();

        return $imageModel;
    }
}