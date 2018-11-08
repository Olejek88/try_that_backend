<?php

return [
    // правило вероятно не нужно
    'GET /' => 'site/index',

    // пока действий мало, оставим так
    '/v1/signup/request' => 'v1/user/signup/request',
    '/v1/signup/options' => 'v1/user/signup/options',
    '/v1/auth/request' => 'v1/user/auth/request',

    // в качестве примера, т.к. модуль не про объекты а сервисный
//    [
//        'class' => 'yii\rest\UrlRule',
//        'controller' => [
//            'v1/payments/pay'
//        ],
//        'extraPatterns' => [
//            'GET pay-systems-list' => 'pay-systems-list',
//        ]
//    ],

    // правила для работы с контроллерами которые не представляют самостоятельных объектов
    '<module:[\w|-]+>/<controller:[\w|-]+>/<action:[\w|-]+>' => '<module>/<controller>/<action>',
    '<module:[\w|-]+>/<submodule:[\w|-]+>/<controller:[\w|-]+>/<action:[\w|-]+>' => '<module>/<submodule>/<controller>/<action>',
];
