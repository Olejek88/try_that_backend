<?php

namespace common\components;

use common\models\IRbacRuleParams;
use yii\db\ActiveRecord;

/** @noinspection UndetectableTableInspection */

/**
 * Class BaseRecord
 * @package common\components
 *
 * @property array $permissions
 */
class BaseRecord extends ActiveRecord implements IRbacRuleParams
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

    public function getRuleParams($action)
    {
        return [];
    }

    public function formName()
    {
        return '';
    }

    protected function getOperator($qryString)
    {
        switch ($qryString) {
            case strpos($qryString, '>=') === 0:
                $operator = '>=';
                break;
            case strpos($qryString, '>') === 0:
                $operator = '>';
                break;
            case strpos($qryString, '<=') === 0:
                $operator = '<=';
                break;
            case strpos($qryString, '<') === 0:
                $operator = '<';
                break;
            default:
                $operator = 'like';
                break;
        }

        return $operator;
    }

    /**
     * @param $fieldName string
     * @return array
     */
    protected function getNumericFilter($fieldName)
    {
        if (is_numeric($this->$fieldName)) {
            $filter = [$fieldName => $this->$fieldName];
        } else {
            $btw = explode('-', $this->$fieldName);
            if (count($btw) == 2 && is_numeric($btw[0]) && is_numeric($btw[1])) {
                $filter = ['between', $fieldName, $btw[0], $btw[1]];
            } else {
                $operator = $this->getOperator($this->$fieldName);
                $operand = str_replace($operator, '', $this->$fieldName);
                $filter = [$operator, $fieldName, $operand];
            }
        }

        return $filter;
    }

    /**
     * @param $fieldName string
     * @return array
     */
    protected function getDateTimeFilter($fieldName)
    {
        $operator = $this->getOperator($this->$fieldName);
        $operand = str_replace($operator, '', $this->$fieldName);
        $filter = [$operator, $fieldName, $operand];
        return $filter;
    }
}