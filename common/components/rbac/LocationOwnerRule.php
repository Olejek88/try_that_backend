<?php

namespace common\components\rbac;

use yii\rbac\Rule;

class LocationOwnerRule extends Rule
{
    public $name = 'isLocationOwner';

    /**
     * @param string|int $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        /* @var \common\models\Location $obj */
        $obj = isset($params['Location']) ? $params['Location'] : null;
        if ($obj != null) {
            // TODO: добавить поле luminary_id в модель Location, либо реализовать один справочник для всех
            return false;
        } else {
            return false;
        }
    }
}