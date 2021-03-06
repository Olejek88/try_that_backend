<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\OrderStatusQuery;
use Yii;

/**
 * This is the model class for table "{{%order_status}}".
 *
 * @property int $id
 * @property string $title
 *
 * @property Order[] $orders
 */
class OrderStatus extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 128],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['order_status_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\OrderStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderStatusQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'orders';
        return $fields;
    }
}
