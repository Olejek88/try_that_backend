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
    public $country_id;
    public $location_id;

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
            ['password', 'string', 'min' => 6],
            ['country_id', 'required'],
            ['country_id', 'integer'],
            ['location_id', 'required'],
            ['location_id', 'integer'],
        ];
    }
}
