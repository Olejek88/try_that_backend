<?php

namespace common\components\rbac;

use yii\rbac\Rule;

class ActivityOwnerRule extends Rule
{
    public $name = 'isActivityOwner';

    /**
     * @param string|int $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        /* @var \common\models\Activity $obj */
        $obj = isset($params['Activity']) ? $params['Activity'] : null;
        if ($obj != null) {
            return $obj->luminary->user_id == $user;
        } else {
            return false;
        }
    }
}