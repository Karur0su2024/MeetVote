<?php


return [

    'service_enabled' => env('GOOGLE_SERVICE_ENABLED', false),
    'client_id' => env('GOOGLE_CLIENT_ID', null),
    'client_secret' => env('GOOGLE_CLIENT_SECRET', null),
    'redirect' => env('GOOGLE_REDIRECT_URI', null),

    'calendar_enabled' => env('GOOGLE_CALENDAR_ENABLED', false),

    'oauth_scopes' => [
            'openid',
            'email',
            'profile'
    ],

    'calendar_scopes' => [
        'https://www.googleapis.com/auth/calendar',
        'https://www.googleapis.com/auth/calendar.events'
    ],

    'oauth_credentials' => storage_path('app/oauth-credentials.json'),


];
