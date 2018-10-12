<?php

return [
    'v1' => [
        'class' => api\modules\v1\Module::class,
        'modules' => [
            'userAuth' => [
                'class' => api\modules\v1\modules\user\Module::class,
            ],
            'payments' => [
                'class' => api\modules\v1\modules\payments\Module::class,
            ],
        ],
    ],
];
