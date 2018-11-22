<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\ReviewQuery;
use Yii;

/**
 * This is the model class for table "{{%review}}".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $activity_id
 * @property string $description
 * @property int $rate
 *
 * @property Activity $activity
 * @property Customer $customer
 */
class Review extends BaseRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%review}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'activity_id', 'description'], 'required'],
            [['customer_id', 'activity_id', 'rate'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [
                ['activity_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Activity::class,
                'targetAttribute' => ['activity_id' => 'id']
            ],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Customer::class,
                'targetAttribute' => ['customer_id' => 'id']
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
            'customer_id' => Yii::t('app', 'Customer ID'),
            'activity_id' => Yii::t('app', 'Activity ID'),
            'description' => Yii::t('app', 'Description'),
            'rate' => Yii::t('app', 'Rate'),
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
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'activity';
        $fields[] = 'customer';
        return $fields;
    }
}
