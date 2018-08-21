<?php

namespace common\models\user;

use common\models\User;
use Yii;

/**
 * This is the model class for table "{{%user_token}}".
 *
 * @property int $user_id
 * @property string $token
 * @property string $created_at
 * @property string $valid_till
 * @property string $last_access
 * @property int $status
 *
 * @property User $user
 */
class Token extends \yii\db\ActiveRecord
{
    const AUTH_TYPE = 1;
    const PASSWORD_RESET_TYPE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'token'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['created_at', 'valid_till', 'last_access'], 'safe'],
            [['token'], 'string', 'max' => 32],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'token' => Yii::t('app', 'Token'),
            'created_at' => Yii::t('app', 'Created At'),
            'valid_till' => Yii::t('app', 'Valid Till'),
            'last_access' => Yii::t('app', 'Last Access'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TokenQuery(get_called_class());
    }

    /**
     * дергаем время последнего доступа по токену
     */
    public function touchLastAccess()
    {
        $this->last_access = new \yii\db\Expression('CURRENT_TIMESTAMP');
        $this->save(false, ['last_access']);
    }

    /**
     * @return bool
     */
    public function isValid() {
        return time() < strtotime($this->valid_till);
    }
}
