<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mail}}".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $order_id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property int $status_id
 * @property int $activity_id
 * @property int $send_date
 * @property int $read_date
 *
 * @property Activity $activity
 * @property User $fromUser
 * @property MailStatus $status
 * @property Order $order
 * @property User $toUser
 */
class Mail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text', 'order_id', 'from_user_id', 'to_user_id', 'status_id', 'activity_id', 'send_date', 'read_date'], 'required'],
            [['text'], 'string'],
            [['order_id', 'from_user_id', 'to_user_id', 'status_id', 'activity_id', 'send_date', 'read_date'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
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
            'text' => Yii::t('app', 'Text'),
            'order_id' => Yii::t('app', 'Order ID'),
            'from_user_id' => Yii::t('app', 'From User ID'),
            'to_user_id' => Yii::t('app', 'To User ID'),
            'status_id' => Yii::t('app', 'Status ID'),
            'activity_id' => Yii::t('app', 'Activity ID'),
            'send_date' => Yii::t('app', 'Send Date'),
            'read_date' => Yii::t('app', 'Read Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(MailStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\MailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\MailQuery(get_called_class());
    }
}
