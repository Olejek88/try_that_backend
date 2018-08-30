<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 8/10/18
 * Time: 1:12 PM
 */

namespace common\models;


use yii\db\ActiveRecord;

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
 * @property Order $order
 */
class InvoiceQuery extends ActiveRecord
{
    public const PROCEDURE_STATUS_UPDATE_NAME = '{{%update_invoice_status}}';
    public const CHANGE = 'change';
    public const NOT_CHANGE = 'notChange';

    public function getOrder()
    {
        // TODO: Раскоментировать как появится модель заказа
//        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getStatus()
    {
        return $this->hasOne(InvoiceQueryStatus::class, ['id' => 'status_id']);
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
}