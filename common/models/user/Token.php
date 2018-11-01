<?php

namespace common\models\user;

use common\models\query\TokenQuery;
use common\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%user_token}}".
 *
 * @property int $user_id
 * @property string $token
 * @property string $created_at
 * @property string $valid_till
 * @property string $last_access
 * @property int $token_type
 *
 * @property User $user
 */
class Token extends ActiveRecord
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
            [['user_id', 'token_type'], 'integer'],
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
            'token_type' => Yii::t('app', 'Type'),
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
        return new TokenQuery(get_called_class());
    }

    /**
     * дергаем время последнего доступа по токену
     */
    public function touchLastAccess()
    {
        $this->last_access = new Expression('CURRENT_TIMESTAMP');
        $this->save(false, ['last_access']);
    }

    /**
     * Продляем действие токена
     */
    public function extensionValidTill()
    {
        $this->valid_till = date(DATE_W3C, strtotime('+1 week'));
        $this->save(false, ['valid_till']);
    }

    /**
     * @return bool
     */
    public function isValid() {
        return time() < strtotime($this->valid_till);
    }

    public static function primaryKey()
    {
        return ['token'];
    }
}
