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
 */
class InvoiceQuery extends ActiveRecord
{
    public function getOrder() {
        // TODO: Раскоментировать как появится модель заказа
//        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getStatus() {
        return $this->hasOne(PaySystemStatus::class, ['id' => 'status_id']);
    }
}