<?php

namespace common\components\rbac;

use yii\rbac\Rule;

class ImageOwnerRule extends Rule
{
    public $name = 'isImageOwner';

    /**
     * @param string|int $user the user ID.
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        // прямой связи между пользователем и изображением нет, по этому,
        // всегда говорим что он не является владельцем изображения
        return false;
    }
}