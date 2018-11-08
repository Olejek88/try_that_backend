<?php

namespace common\components\rbac;

use yii\rbac\Rule;

class TagOwnerRule extends Rule
{
    public $name = 'isTagOwner';

    /**
     * @param string|int $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        /* @var \common\models\Tag $obj */
        $obj = isset($params['Tag']) ? $params['Tag'] : null;
        if ($obj != null) {
            // так как теги напрямую не связанны с продавцами, всегда возвращаем false
            return false;
        } else {
            return false;
        }
    }
}