<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 8/24/18
 * Time: 6:54 PM
 */

namespace common\components;


use yii\base\BootstrapInterface;
use yii\base\UnknownClassException;

class PaySystemAutoload implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $classes = [];
        if (!empty(\Yii::$app->params['paySystems']['classes'])) {
            $classes = \Yii::$app->params['paySystems']['classes'];
            if (!is_array($classes)) {
                $classes = [];
            }
        }

        foreach ($classes as $paySystemClass => $classParams) {
            try {
                \Yii::autoload($paySystemClass);
            } catch (UnknownClassException $exception) {

            }
        }
    }

}