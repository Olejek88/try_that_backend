<?php

namespace common\models;

use common\models\query\UserImageQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_image}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $image_id
 *
 * @property ActivityImage[] $activityImages
 * @property User[] $users
 * @property Image $image
 * @property User $user
 */
class UserImage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'image_id'], 'required'],
            [['user_id', 'image_id'], 'integer'],
            [
                ['image_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Image::class,
                'targetAttribute' => ['image_id' => 'id']
            ],
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
            'image_id' => Yii::t('app', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityImages()
    {
        return $this->hasMany(ActivityImage::class, ['user_image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['user_image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
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
     * @return UserImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserImageQuery(get_called_class());
    }
}
