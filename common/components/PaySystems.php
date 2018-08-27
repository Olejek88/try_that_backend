<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 7/18/18
 * Time: 3:23 PM
 */

namespace common\components;

use common\models\PaySystem;

class PaySystems
{
    private $classes;

    /**
     * PaySystems constructor.
     * @param $interface
     */
    public function __construct($interface = PaySystemInterface::class)
    {
        $this->classes = [];

        $classes = self::getImplementingClasses($interface);
        foreach ($classes as $name => $class) {
            /* @var $ps PaySystemInterface */
            $ps = new $class;
            $this->classes[$ps->getName()] = $class;
        }
    }

    /**
     * Возвращает все доступные классы которые реализуют интерфейс PaySystemInterface.
     *
     * @return array
     */
    public function getPaySystems()
    {
        return $this->classes;
    }

    /**
     * Возвращает все доступные для пользователя классы платёжных систем которые прямо не запрещены.
     *
     * @return array
     */
    public function getEnabledPaySystems()
    {
        $result = [];
        foreach ($this->classes as $name => $class) {
            if (self::isEnabled($class)) {
                $result[$name] = $class;
            }
        }

        return $result;
    }

    /**
     * Проверяет "отключена" ли платёжная система для использования.
     *
     * @param $class string
     * @return boolean
     */
    public static function isEnabled($class)
    {
        $classes = self::getImplementingClasses();
        if (in_array($class, $classes)) {
            return PaySystem::findOne(['class' => $class, 'enable' => 0]) == null;
        } else {
            return false;
        }
    }

    public static function getImplementingClasses($interfaceName = PaySystemInterface::class)
    {
        return array_filter(
            get_declared_classes(),
            function ($className) use ($interfaceName) {
                return in_array($interfaceName, class_implements($className));
            }
        );
    }
}