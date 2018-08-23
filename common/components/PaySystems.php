<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 7/18/18
 * Time: 3:23 PM
 */

namespace common\components;

use yii\base\UnknownClassException;

class PaySystems
{
    private static $instance;
    private $classes;

    /**
     * PaySystems constructor.
     * @param $classes
     * @param $interface
     */
    private function __construct($classes, $interface = IPaySystem::class)
    {
        $this->classes = [];

        if (!is_array($classes)) {
            return;
        }

        foreach ($classes as $paySystemClass) {
            try {
                \Yii::autoload($paySystemClass);
            } catch (UnknownClassException $exception) {
                var_dump($exception);
            }
        }

        $classes = self::getImplementingClasses($interface);
        foreach ($classes as $name => $class) {
            /* @var $ps IPaySystem */
            $ps = new $class;
            $this->classes[$ps->getName()] = $class;
        }

        // TODO: Реализовать инициализацию маршрутов которые предоставляют модули платёжных систем
        // т.е. динамически настраеваем следующее поведение - платежной системе нельзя указать backUrl
        // либо урл по которому она будет нас уведомлять о состоянии заявки на оплату. Т.е. урл жестко
        // задан платёжной системой. Т.е. нам нужно /foo/bar/paysystem/info перенаправить на pay/info

    }

    /**
     * Создаёт загружает существующие классы из конфига, строит их список.
     *
     * @return PaySystems
     */
    public static function getInstance()
    {
        if (PaySystems::$instance == null) {
            $ps = [];
            if (!empty(\Yii::$app->params['paySystems']['classes'])) {
                $ps = \Yii::$app->params['paySystems']['classes'];
                if (!is_array($ps)) {
                    $ps = [];
                }
            }

            PaySystems::$instance = new PaySystems(array_keys($ps));
        }

        return PaySystems::$instance;
    }

    public function getPaySystems()
    {
        return $this->classes;
    }

    public static function getImplementingClasses($interfaceName)
    {
        return array_filter(
            get_declared_classes(),
            function ($className) use ($interfaceName) {
                return in_array($interfaceName, class_implements($className));
            }
        );
    }

    private function __wakeup()
    {
    }

    private function __clone()
    {
    }
}