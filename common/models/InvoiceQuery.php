<?php

namespace common\models;

use common\components\BaseRecord;
use common\models\query\InvoiceQueryQuery;

/**
 * Class InvoiceQuery
 * @package common\models
 *
 * @property integer $id
 * @property string $pay_system_class
 * @property string $pay_system_name
 * @property integer $order_id
 * @property string $description
 * @property float $cost
 * @property string $extra_info
 * @property integer $status_id
 * @property string $status_date
 * @property string $create_date
 * @property string $last_check
 *
 * @property InvoiceQueryStatus $status
 * @property Order $order
 */
class InvoiceQuery extends BaseRecord
{
    public const PROCEDURE_STATUS_UPDATE_NAME = '{{%update_invoice_status}}';
    public const CHANGE = 'change';
    public const NOT_CHANGE = 'notChange';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%invoice_query}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pay_system_class', 'pay_system_name', 'order_id', 'extra_info'], 'required'],
            [['order_id', 'status_id'], 'integer'],
            [['cost'], 'number'],
            [['extra_info'], 'string'],
            [['status_date', 'create_date', 'last_check'], 'datetime', 'format' => 'php:Y-m-d H:s:i'],
            [['pay_system_class', 'pay_system_name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 255],
            [['order_id'], 'unique'],
            [
                ['order_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Order::class,
                'targetAttribute' => ['order_id' => 'id']
            ],
            [
                ['status_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => InvoiceQueryStatus::class,
                'targetAttribute' => ['status_id' => 'id']
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
            'pay_system_class' => \Yii::t('app', 'Pay System Class'),
            'pay_system_name' => \Yii::t('app', 'Pay System Name'),
            'order_id' => \Yii::t('app', 'Order ID'),
            'description' => \Yii::t('app', 'Description'),
            'cost' => \Yii::t('app', 'Cost'),
            'extra_info' => \Yii::t('app', 'Extra Info'),
            'status_id' => \Yii::t('app', 'Status ID'),
            'status_date' => \Yii::t('app', 'Status Date'),
            'create_date' => \Yii::t('app', 'Create Date'),
            'last_check' => \Yii::t('app', 'Last Check'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getStatus()
    {
        return $this->hasOne(InvoiceQueryStatus::class, ['id' => 'status_id']);
    }

    public function setStatusNew()
    {
        $this->status_id = InvoiceQueryStatus::NEW_ID;
    }

    public function setStatusRegistered()
    {
        $this->status_id = InvoiceQueryStatus::REGISTERED_ID;
    }

    public function setStatusWaitingForPay()
    {
        $this->status_id = InvoiceQueryStatus::WAITING_FOR_PAY_ID;
    }

    public function setStatusWaitingForConfirm()
    {
        $this->status_id = InvoiceQueryStatus::WAITING_FOR_CONFIRM_ID;
    }

    public function setStatusWaitingForBank()
    {
        $this->status_id = InvoiceQueryStatus::WAITING_FOR_BANK_ID;
    }

    public function setStatusPreAuth()
    {
        $this->status_id = InvoiceQueryStatus::PRE_AUTH_ID;
    }

    public function setStatusPayed()
    {
        $this->status_id = InvoiceQueryStatus::PAYED_ID;
    }

    public function setStatusNotPayed()
    {
        $this->status_id = InvoiceQueryStatus::NOT_PAYED_ID;
    }

    public function setStatusCanceled()
    {
        $this->status_id = InvoiceQueryStatus::CANCELED_ID;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->status_id == InvoiceQueryStatus::NEW_ID;
    }

    /**
     * @return bool
     */
    public function isRegistered()
    {
        return $this->status_id == InvoiceQueryStatus::REGISTERED_ID;
    }

    /**
     * @return bool
     */
    public function isWaitingForPay()
    {
        return $this->status_id == InvoiceQueryStatus::WAITING_FOR_PAY_ID;
    }

    /**
     * @return bool
     */
    public function isWaitingForConfirm()
    {
        return $this->status_id == InvoiceQueryStatus::WAITING_FOR_CONFIRM_ID;
    }

    /**
     * @return bool
     */
    public function isWaitingForBank()
    {
        return $this->status_id == InvoiceQueryStatus::WAITING_FOR_BANK_ID;
    }

    /**
     * @return bool
     */
    public function isPreAuth()
    {
        return $this->status_id == InvoiceQueryStatus::PRE_AUTH_ID;
    }

    /**
     * @return bool
     */
    public function isPayed()
    {
        return $this->status_id == InvoiceQueryStatus::PAYED_ID;
    }

    /**
     * @return bool
     */
    public function isNotPayed()
    {
        return $this->status_id == InvoiceQueryStatus::NOT_PAYED_ID;
    }

    /**
     * @return bool
     */
    public function isCanceled()
    {
        return $this->status_id == InvoiceQueryStatus::CANCELED_ID;
    }

    /**
     * @return bool
     */
    public function isWaitingPruf()
    {
        $statuses = [
            InvoiceQueryStatus::WAITING_FOR_CONFIRM_ID,
            InvoiceQueryStatus::WAITING_FOR_BANK_ID,
            InvoiceQueryStatus::PRE_AUTH_ID,
        ];

        return in_array($this->status_id, $statuses);
    }

    /**
     * @return bool
     */
    public function isAllowNewPay()
    {
        $statuses = [
            InvoiceQueryStatus::NEW_ID,
            InvoiceQueryStatus::REGISTERED_ID,
            InvoiceQueryStatus::WAITING_FOR_PAY_ID,
            InvoiceQueryStatus::NOT_PAYED_ID,
            InvoiceQueryStatus::CANCELED_ID,
        ];

        return in_array($this->status_id, $statuses);
    }

    /**
     *
     * @param $statusId integer
     * @param $updateDate string
     * @return string
     */
    public function updateStatus($statusId, $updateDate)
    {
        $sql = "CALL " . self::PROCEDURE_STATUS_UPDATE_NAME . "(:queryId, :statusId, :date)";
        $params = [':queryId' => $this->id, ':statusId' => $statusId, ':date' => $updateDate];
        try {
            return \Yii::$app->db->createCommand($sql, $params)->queryOne();
        } catch (\Exception $exception) {
            return self::NOT_CHANGE;
        }
    }

    /**
     * Возвращает текстовое соответсвие коду статуса.
     *
     * @param $id integer
     * @return string
     */
    public static function getStatusString($id)
    {
        switch ($id) {
            case 1 :
                return InvoiceQueryStatus::NEW;
            case 2 :
                return InvoiceQueryStatus::REGISTERED;
            case 3 :
                return InvoiceQueryStatus::WAITING_FOR_PAY;
            case 4 :
                return InvoiceQueryStatus::WAITING_FOR_CONFIRM;
            case 5 :
                return InvoiceQueryStatus::WAITING_FOR_BANK;
            case 6 :
                return InvoiceQueryStatus::PRE_AUTH;
            case 7 :
                return InvoiceQueryStatus::PAYED;
            case 8 :
                return InvoiceQueryStatus::NOT_PAYED;
            case 9 :
                return InvoiceQueryStatus::CANCELED;
            default:
                return 'unknown';
        }
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\InvoiceQueryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQueryQuery(get_called_class());
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields[] = 'status';
        $fields[] = 'order';
        return $fields;
    }
}