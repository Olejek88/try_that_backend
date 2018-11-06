<?php

return [
    // правило вероятно не нужно
    'GET /' => 'site/index',

    // пока действий мало, оставим так
    '/v1/signup/request' => 'v1/userAuth/signup/request',
    '/v1/auth/request' => 'v1/userAuth/auth/request',

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

    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/activity-category',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/tag',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/activity-image',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/activity-listing',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/activity',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/category',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/country',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/customer',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/duration',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/exception-t-t',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/follow-list',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/group-experience',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/invoice-query',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/invoice-query-status',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/location',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/luminary',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/mail',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/mail-status',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/news',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/news-image',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/occasion',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/order',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/order-status',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/review',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/trending',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user-attribute',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user-image',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/wishlist',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/activity-duration',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/activity-tag',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/image',],
    ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/currency',],

    // правила для работы с контроллерами которые не представляют самостоятельных объектов
    '<module:[\w|-]+>/<controller:[\w|-]+>/<action:[\w|-]+>' => '<module>/<controller>/<action>',
    '<module:[\w|-]+>/<submodule:[\w|-]+>/<controller:[\w|-]+>/<action:[\w|-]+>' => '<module>/<submodule>/<controller>/<action>',
];
