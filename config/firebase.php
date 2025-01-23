<?php

use Illuminate\Support\Facades\Log;

return [
    'credentials' => storage_path(env('FIREBASE_CREDENTIALS')),
    'database_url' => env('FIREBASE_DATABASE_URL'),
    'default' => [
        'auth' => true,
        'database' => true,
        'storage' => true,
    ],
    'log' => function() {
        Log::info('Firebase Credentials loaded: ' . env('FIREBASE_CREDENTIALS'));
    },
];
