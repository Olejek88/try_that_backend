<?php

namespace common\components\rbac;

use yii\rbac\Rule;

class UserOwnerRule extends Rule
{
    public $name = 'isUserOwner';

    /**
     * @param string|int $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        /* @var \common\models\User $obj */
        $obj = isset($params['User']) ? $params['User'] : null;
        if ($obj != null) {
            return $obj->id == $user;
        } else {
            return false;
        }
    }
}