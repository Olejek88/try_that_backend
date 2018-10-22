<?php

namespace common\models;

use common\models\query\ActivityImageQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%activity_image}}".
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_image_id
 *
 * @property Activity $activity
 * @property Image $image
 */
class ActivityImage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_image}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'user_image_id'], 'required'],
            [['activity_id', 'user_image_id'], 'integer'],
            [
                ['activity_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Activity::class,
                'targetAttribute' => ['activity_id' => 'id']
            ],
            [
                ['user_image_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => UserImage::class,
                'targetAttribute' => ['user_image_id' => 'id']
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
            'activity_id' => Yii::t('app', 'Activity ID'),
            'image_id' => Yii::t('app', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::class, ['id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }

    /**
     * {@inheritdoc}
     * @return ActivityImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivityImageQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activity';
        $fields[] = 'image';
        return $fields;
    }

}
