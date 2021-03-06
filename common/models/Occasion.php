<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\OccasionQuery;
use Yii;

/**
 * This is the model class for table "{{%occasion}}".
 *
 * @property int $id
 * @property string $title
 * @property int $activity_id
 * @property int $image_id
 *
 * @property Activity $activity
 * @property Image $image
 */
class Occasion extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%occasion}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'activity_id', 'image_id'], 'required'],
            [['activity_id', 'image_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [
                ['activity_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Activity::class,
                'targetAttribute' => ['activity_id' => 'id']
            ],
            [
                ['image_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Image::class,
                'targetAttribute' => ['image_id' => 'id']
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
            'title' => Yii::t('app', 'Title'),
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
     * @return \common\models\query\OccasionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OccasionQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activity';
        $fields[] = 'image';
        return $fields;
    }
}
