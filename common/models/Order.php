<?php

namespace common\models;

use common\models\query\OrderQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property int $activity_listing_id
 * @property int $order_status_id
 * @property string $start_date
 * @property int $created_at
 * @property int $updated_at
 * @property int $customer_id
 *
 * @property Mail[] $mails
 * @property ActivityListing $activityListing
 * @property OrderStatus $orderStatus
 * @property Customer $customer
 */
class Order extends ActiveRecord
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
            [['activity_listing_id', 'order_status_id', 'created_at', 'updated_at'], 'required'],
            [['activity_listing_id', 'order_status_id', 'created_at', 'updated_at'], 'integer'],
            [['start_date'], 'safe'],
            [
                ['activity_listing_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => ActivityListing::class,
                'targetAttribute' => ['activity_listing_id' => 'id']
            ],
            [
                ['order_status_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => OrderStatus::class,
                'targetAttribute' => ['order_status_id' => 'id']
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
            'activity_listing_id' => Yii::t('app', 'Activity Listing ID'),
            'order_status_id' => Yii::t('app', 'Order Status ID'),
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
        return $this->hasMany(Mail::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityListing()
    {
        return $this->hasOne(ActivityListing::class, ['id' => 'activity_listing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::class, ['id' => 'order_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'mails';
        $fields[] = 'activityListing';
        $fields[] = 'orderStatus';
        $fields[] = 'customer';
        return $fields;
    }
}
