<?php
/**
 * Created by PhpStorm.
 * User: msdev
 * Date: 18.07.18
 * Time: 1:12
 */

namespace api\modules\v1;

use api\modules\v1\components\PaySystems;

class Module extends \yii\base\Module
{
    /**
     * Namespace
     *
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1';

    public function init()
    {
        parent::init();
        // TODO: Переписать без всяких синглтонов.
        // Создание экземпляра, вызов метода getAllUrlRules, динамическая установка полученых правил.
        $ps = PaySystems::getInstance();
    }
}
