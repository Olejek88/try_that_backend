<?php

namespace api\models\form;

use api\models\User;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package api\models\form
 */
class LoginForm extends Model
{
    /**
     * @var string $email
     */
    public $email;
    /**
     * @var string $password
     */
    public $password;
    /**
     * @var User
     */
    protected $user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user
                || !$user->validatePassword($this->password)
                || !$user->role
//              || !in_array($user->role, User::$back_allowed_roles)
            ) {
                $this->addError($attribute, Yii::t('site', 'error_password'));
            }
        }
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === null) {
            $this->user = User::findByLogin($this->email);
        }

        return $this->user;
    }
}
