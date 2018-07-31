<?php

$urlManager = [
    'class' => yii\web\UrlManager::class,
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => require(__DIR__ . '/_rules.php'),

    'baseUrl' => '/',
];

return $urlManager;
