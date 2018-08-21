<?php

namespace api\models\form;

use common\models\User;
use yii\base\Model;

/**
 * Class SignupForm
 * @package api\models\form
 */
class SignupForm extends Model
{
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'message' => '',
            ],

            ['password', 'required'],
            ['password', 'string', 'min' => 6]
        ];
    }
}
