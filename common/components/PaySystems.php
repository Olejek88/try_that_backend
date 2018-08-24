<?php
/**
 * Created by PhpStorm.
 * User: koputo
 * Date: 7/18/18
 * Time: 3:23 PM
 */

namespace common\components;

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
}