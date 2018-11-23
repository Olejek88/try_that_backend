<?php

namespace common\models;

interface IRbacRuleParams
{
    /**
     * @param $action string
     * @return array
     */
    public function getRuleParams($action);
}