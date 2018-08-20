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
 * Class PaySystemStatus
 * @package common\models
 *
 * @property integer $id
 * @property string $name
 * @property string $title
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

}