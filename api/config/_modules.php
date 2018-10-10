<?php

return [
    'v1' => [
        'class' => api\modules\v1\Module::class,
        'modules' => [
            'user' => [
                'class' => api\modules\v1\modules\user\Module::class,
            ],
        ],
    ],
];
