<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%activity_category}}".
 *
 * @property int $id
 * @property string $title
 * @property int $image_id
 *
 * @property Activity[] $activities
 * @property Image $image
 */
class ActivityCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['image_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'image_id' => Yii::t('app', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['activity_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ActivityCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ActivityCategoryQuery(get_called_class());
    }
}
