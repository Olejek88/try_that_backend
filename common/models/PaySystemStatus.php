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
    public const REGISTERED_ID = 2;
    public const WAITING_FOR_PAY_ID = 3;
    public const WAITING_FOR_CONFIRM_ID = 4;
    public const WAITING_FOR_BANK_ID = 5;
    public const PRE_AUTH_ID = 6;
    public const PAYED_ID = 7;
    public const NOT_PAYED_ID = 8;
    public const CANCELED_ID = 9;

}