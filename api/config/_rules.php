<?php

return [
    'GET /' => 'site/index',
    '/v1/signup/request' => 'v1/user/signup/request',
    '/v1/auth/request' => 'v1/user/auth/request',
    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
    '<module:\w+>/<submodule:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<submodule>/<controller>/<action>',
];
