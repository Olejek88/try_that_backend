<?php

namespace api\models;

use api\helpers\Html;

/**
 * Class User
 * @package api\models
 */
class User extends \common\models\User
{
    /**
     * Запрос на регистрацию
     * @param string $email
     * @param string $password
     * @return static
     * @throws \yii\base\Exception
     */
    public static function requestSignup(string $email, string $password, int $country_id, int $location_id)
    {
        $user = new static();
        $user->username = $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->country_id = $country_id;
        $user->location_id = $location_id;
        if (!$user->save()) {
            throw new \DomainException('User create error: ' . strip_tags(Html::errorSummary([$user])));
        }

        return $user;
    }
}
