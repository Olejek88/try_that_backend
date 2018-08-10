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
class PaySystemStatus extends ActiveRecord
{
    public const NEW_ID = 1;
    public const NEW = 'new';
    public const REGISTERED_ID = 2;
    public const REGISTERED = 'registered';
    public const WAITING_FOR_PAY_ID = 3;
    public const WAITING_FOR_PAY = 'waiting_for_pay';
    public const WAITING_FOR_CONFIRM_ID = 4;
    public const WAITING_FOR_CONFIRM = 'waiting_for_confirm';
    public const WAITING_FOR_BANK_ID = 5;
    public const WAITING_FOR_BANK = 'waiting_for_bank';
    public const PRE_AUTH_ID = 6;
    public const PRE_AUTH = 'pre_auth';
    public const PAYED_ID = 7;
    public const PAYED = 'payed';
    public const NOT_PAYED_ID = 8;
    public const NOT_PAYED = 'not_payed';
    public const CANCELED_ID = 9;
    public const CANCELED = 'canceled';

}