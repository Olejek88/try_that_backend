<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%activity_image}}".
 *
 * @property int $id
 * @property int $activity_id
 * @property int $image_id
 *
 * @property Activity $activity
 * @property Image $image
 */
class ActivityImage extends \yii\db\ActiveRecord
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
            [['activity_id', 'image_id'], 'required'],
            [['activity_id', 'image_id'], 'integer'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::class, 'targetAttribute' => ['activity_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
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
     * @return \common\models\query\ActivityImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ActivityImageQuery(get_called_class());
    }
}
