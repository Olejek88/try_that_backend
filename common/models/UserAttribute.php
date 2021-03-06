<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\UserAttributeQuery;
use Yii;

/**
 * This is the model class for table "{{%user_attribute}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $value
 *
 * @property User $user
 */
class UserAttribute extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_attribute}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['name', 'value'], 'string', 'max' => 128],
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
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
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
     * @return \common\models\query\UserAttributeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserAttributeQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'user';
        return $fields;
    }
}
