<?php

namespace common\models;


use common\components\BaseRecord;
use common\models\query\ActivityDurationQuery;

/**
 * This is the model class for table "{{%activity_duration}}".
 *
 * @property int $id
 * @property int $activity_id
 * @property int $duration_id
 *
 * @property Luminary $luminary
 * @property Activity $activity
 * @property Duration $duration
 */
class ActivityDuration extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%activity_duration}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'duration_id'], 'required'],
            [['activity_id', 'duration_id'], 'integer'],
            [
                ['activity_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Activity::class,
                'targetAttribute' => ['activity_id' => 'id']
            ],
            [
                ['duration_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Duration::class,
                'targetAttribute' => ['duration_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'activity_id' => \Yii::t('app', 'Activity ID'),
            'duration_id' => \Yii::t('app', 'Duration ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLuminary()
    {
        return $this->hasOne(Luminary::class, ['id' => 'luminary_id'])->via('duration');
    }

    public function getActivity()
    {
        return $this->hasOne(Activity::class, ['id' => 'activity_id']);
    }

    public function getDuration()
    {
        return $this->hasOne(Duration::class, ['id' => 'duration_id']);
    }

    public static function find()
    {
        return new ActivityDurationQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'luminary';
        $fields[] = 'activity';
        $fields[] = 'duration';
        return $fields;
    }

}