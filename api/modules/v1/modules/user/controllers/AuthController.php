<?php

namespace api\modules\v1\modules\user;

use api\models\form\LoginForm;
use Yii;
use yii\rest\Controller;

class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['password'] = ['POST', 'OPTIONS'];
        return $verbs;
    }

    /**
     * @return LoginForm|array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPassword()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($model->validate()) {
            $user = $model->getUser();
            $token = $user->generateAccessToken();
            $user->save();

            return [
                'user_id' => $user->id,
                'token' => $token,
            ];
        } else {
            return $model;
        }
    }

}
