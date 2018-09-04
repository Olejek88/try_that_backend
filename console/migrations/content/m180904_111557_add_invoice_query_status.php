<?php

use yii\db\Migration;
use common\models\InvoiceQueryStatus;

/**
 * Class m180904_111557_add_invoice_query_status
 */
class m180904_111557_add_invoice_query_status extends Migration
{
    const INVOICE_QUERY_STATUS = '{{%invoice_query_status}}';

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->batchInsert(self::INVOICE_QUERY_STATUS,
            ['id', 'name', 'title'],
            [
                [InvoiceQueryStatus::NEW_ID, 'new', 'Новый'],
                [InvoiceQueryStatus::REGISTERED_ID, 'registered', 'Зарегестрирован'],
                [InvoiceQueryStatus::WAITING_FOR_PAY_ID, 'waiting_for_pay', 'Ожидает оплаты'],
                [InvoiceQueryStatus::WAITING_FOR_CONFIRM_ID, 'waiting_for_confirm', 'Ожидает подтверждения'],
                [InvoiceQueryStatus::WAITING_FOR_BANK_ID, 'waiting_for_bank', 'Ожидает подтверждения банка'],
                [InvoiceQueryStatus::PRE_AUTH_ID, 'preauth', 'Средства заблокированы'],
                [InvoiceQueryStatus::PAYED_ID, 'payed', 'Олачен'],
                [InvoiceQueryStatus::NOT_PAYED_ID, 'notpayed', 'Не оплачен'],
                [InvoiceQueryStatus::CANCELED_ID, 'canceled', 'Отменён'],
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180904_111557_add_invoice_query_status cannot be reverted.\n";
        $this->delete(self::INVOICE_QUERY_STATUS, [
            'id' => [
                InvoiceQueryStatus::NEW_ID,
                InvoiceQueryStatus::REGISTERED_ID,
                InvoiceQueryStatus::WAITING_FOR_PAY_ID,
                InvoiceQueryStatus::WAITING_FOR_CONFIRM_ID,
                InvoiceQueryStatus::WAITING_FOR_BANK_ID,
                InvoiceQueryStatus::PRE_AUTH_ID,
                InvoiceQueryStatus::PAYED_ID,
                InvoiceQueryStatus::NOT_PAYED_ID,
                InvoiceQueryStatus::CANCELED_ID,
            ]
        ]);
        return true;
    }
}
