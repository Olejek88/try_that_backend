<?php

namespace common\components\rbac;

use yii\rbac\Rule;

class TrendingOwnerRule extends Rule
{
    public $name = 'isTrendingOwner';

    /**
     * @param string|int $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        /* @var \common\models\Trending $obj */
        $obj = isset($params['Trending']) ? $params['Trending'] : null;
        if ($obj != null) {
            // так как объект напрямую не связан ни с продавцами ни с покупателями, возвращаем false
            return false;
        } else {
            return false;
        }
    }
}