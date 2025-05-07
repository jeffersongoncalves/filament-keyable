<?php

use Givebutter\LaravelKeyable\Models\ApiKey;

return [
    'api_key_resource' => [
        'cluster' => null,
        'model' => ApiKey::class,
        'should_register_navigation' => true,
        'navigation_badge' => true,
        'navigation_sort' => -1,
        'slug' => 'settings/api-keys',
        'models' => [
            // App\Models\User::class,
            // App\Models\Customer::class,
        ],
    ],
];
