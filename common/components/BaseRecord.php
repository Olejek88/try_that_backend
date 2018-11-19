<?php

namespace common\components;

use yii\db\ActiveRecord;

/** @noinspection UndetectableTableInspection */

/**
 * Class BaseRecord
 * @package common\components
 *
 * @property array $permissions
 */
class BaseRecord extends ActiveRecord
{
    /**
     * @return array
     */
    public function getPermissions() {

        $class = explode('\\', get_class($this));
        $class = $class[count($class) - 1];

        return [
            'create' => 'create' . $class,
            'read' => 'read' . $class,
            'update' => 'update' . $class,
            'delete'=> 'delete' . $class,
        ];
    }

    public function formName()
    {
        return '';
    }
}