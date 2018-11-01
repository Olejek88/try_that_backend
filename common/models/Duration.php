<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\DurationQuery;
use Yii;

/**
 * This is the model class for table "{{%duration}}".
 *
 * @property int $id
 * @property string $date
 *
 * @property Activity[] $activities
 * @property ActivityListing[] $activityListings
 * @property Order[] $orders
 */
class Duration extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%duration}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::class, ['duration_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityListings()
    {
        return $this->hasMany(ActivityListing::class, ['duration_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['duration_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\DurationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DurationQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activities';
        $fields[] = 'activityListings';
        $fields[] = 'orders';
        return $fields;
    }
}
