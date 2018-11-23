<?php

namespace common\components\rbac;

use yii\rbac\Rule;

class InvoiceQueryOwnerRule extends Rule
{
    public $name = 'isInvoiceQueryOwner';

    /**
     * @param string|int $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        /* @var \common\models\InvoiceQuery $obj */
        $obj = isset($params['InvoiceQuery']) ? $params['InvoiceQuery'] : null;
        if ($obj != null) {
            return $obj->order->customer->user_id == $user;
        } else {
            return false;
        }
    }
}