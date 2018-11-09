<?php
namespace api\modules\v1\modules\user\controllers;

use api\models\form\SignupForm;
use api\models\User;
use Yii;
use yii\filters\Cors;
use yii\rest\Controller;

/**
 * Class SignupController
 * @package api\modules\v1\modules\user\controllers
 */
class SignupController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            ],
              
        ];

        return $behaviors;
    }
    
    /**
     * @inheritdoc
     */
    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['request'] = ['POST', 'OPTIONS'];
        return $verbs;
    }

    /**
     * @return User|SignupForm
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function actionRequest()
    {
        $form = new SignupForm();
        $request = \Yii::$app->getRequest()->getBodyParams();
        if ($form->load($request, '') && $form->validate()) {
            try {
                return User::requestSignup($form->email, $form->password);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                $form->addError('ALL', 'DomainException: Unknown error');
            }
        }

        return $form;
    }
}
