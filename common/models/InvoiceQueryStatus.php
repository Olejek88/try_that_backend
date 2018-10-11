<?php

namespace common\models;

use common\models\query\InvoiceQueryStatusQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%invoice_query_status}}".
 * @package common\models
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 *
 * @property \yii\db\ActiveQuery $invoiceQueries
 */
class InvoiceQueryStatus extends ActiveRecord
{
    // появляется один раз, в момент создания заявки на оплату
    public const NEW_ID = 1;
    public const NEW = 'new';
    // заявка на оплату зарегистрирована в платёжной системе, оплата ещё не проводилась
    public const REGISTERED_ID = 2;
    public const REGISTERED = 'registered';
    // ожидание оплаты клиента
    public const WAITING_FOR_PAY_ID = 3;
    public const WAITING_FOR_PAY = 'waiting_for_pay';
    // ожидание подтверждения оплаты клиента
    public const WAITING_FOR_CONFIRM_ID = 4;
    public const WAITING_FOR_CONFIRM = 'waiting_for_confirm';
    // запрос в банк ушел успешно, но дополнительно состояние заявки нужно уточнять дополнительно
    public const WAITING_FOR_BANK_ID = 5;
    public const WAITING_FOR_BANK = 'waiting_for_bank';
    // средства заблокированы
    public const PRE_AUTH_ID = 6;
    public const PRE_AUTH = 'pre_auth';
    // платёж прошел, платёж пдтверждён, заблокированные средства списаны
    public const PAYED_ID = 7;
    public const PAYED = 'payed';
    // заявка не оплачивалась(если в течении срока жизни заявки не поступило платежа), платёж не прошел,
    // подтверждение не получено
    public const NOT_PAYED_ID = 8;
    public const NOT_PAYED = 'not_payed';
    // отменена(оплата отменена клиентом, менеджером)
    public const CANCELED_ID = 9;
    public const CANCELED = 'canceled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%invoice_query_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            [['name', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
            'title' => \Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceQueries()
    {
        return $this->hasMany(InvoiceQuery::class, ['status_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return InvoiceQueryStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQueryStatusQuery(get_called_class());
    }
}