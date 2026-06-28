<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Allows the Next.js frontend (Aplikasi 1) to call this Laravel API
    | (Aplikasi 2) from a different origin and send the Authorization
    | bearer token issued by Sanctum.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter(explode(',', env('FRONTEND_URLS', 'http://localhost:3000'))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
