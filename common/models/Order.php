<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property int $activity_listing_id
 * @property int $order_status_id
 * @property int $duration_id
 * @property string $start_date
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Mail[] $mails
 * @property ActivityListing $activityListing
 * @property Duration $duration
 * @property OrderStatus $orderStatus
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_listing_id', 'order_status_id', 'duration_id', 'created_at', 'updated_at'], 'required'],
            [['activity_listing_id', 'order_status_id', 'duration_id', 'created_at', 'updated_at'], 'integer'],
            [['start_date'], 'safe'],
            [['activity_listing_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityListing::className(), 'targetAttribute' => ['activity_listing_id' => 'id']],
            [['duration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Duration::className(), 'targetAttribute' => ['duration_id' => 'id']],
            [['order_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::className(), 'targetAttribute' => ['order_status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activity_listing_id' => Yii::t('app', 'Activity Listing ID'),
            'order_status_id' => Yii::t('app', 'Order Status ID'),
            'duration_id' => Yii::t('app', 'Duration ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMails()
    {
        return $this->hasMany(Mail::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityListing()
    {
        return $this->hasOne(ActivityListing::className(), ['id' => 'activity_listing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDuration()
    {
        return $this->hasOne(Duration::className(), ['id' => 'duration_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'order_status_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\OrderQuery(get_called_class());
    }
}
