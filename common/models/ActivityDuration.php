<?php

namespace common\models;


use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%activity_duration}}".
 *
 * @property int $id
 * @property int $luminary_id
 * @property int $activity_id
 * @property int $duration_id
 *
 * @property Luminary $luminary
 * @property Activity $activity
 * @property Duration $duration
 */
class ActivityDuration extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%activity_duration}}';
    }

    public function getLuminary() {
        return $this->hasOne(Luminary::class, ['id' => 'luminary_id']);
    }

    public function getActivity() {
        return $this->hasOne(Activity::class, ['id' => 'activity_id']);
    }

    public function getDuration() {
        return $this->hasOne(Duration::class, ['id' => 'duration_id']);
    }
}