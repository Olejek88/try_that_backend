<?php

namespace common\components;

use yii\base\BootstrapInterface;

class PaySystemRoute implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $ps = new PaySystems();
        $ps->getPaySystems();
        foreach ($ps->getPaySystems() as $name => $class) {
            /* @var $psi \common\components\PaySystemInterface */
            $psi = new $class;
            \Yii::$app->urlManager->addRules($psi->getRoutes());
        }
    }
}