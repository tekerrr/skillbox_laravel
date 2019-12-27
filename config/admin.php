<?php

return [
    // TODO значения по умолчанию временные, потом убрать
    'email'    => env('ADMIN_EMAIL', 'admin@test.ru'),
    'password' => env('ADMIN_PASSWORD', 'admin'),

    'super' => [
        'email'    => env('SUPER_ADMIN_EMAIL', 'super_admin@test.ru'),
        'password' => env('SUPER_ADMIN_PASSWORD', 'admin'),
    ],
];
