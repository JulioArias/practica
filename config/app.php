<?php

return [
    'name' => env('APP_NAME', 'Inventario Boutique'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'America/Guayaquil'),
    'locale' => env('APP_LOCALE', 'es'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'faker_locale' => 'es_ES',
    'cipher' => 'AES-256-CBC',
    'key' => env('APP_KEY'),
    'maintenance' => [
        'driver' => 'file',
    ],
    'providers' => [
        App\Providers\AppServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ],
];
