<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'gdelt' => [
        'url' => env('GDELT_URL', 'https://api.gdeltproject.org/api/v2/doc/doc'),
        'max_records' => (int) env('GDELT_MAX_RECORDS', 50),
        'timespan' => env('GDELT_TIMESPAN', '24h'),
    ],

    'openalex' => [
        'url' => env('OPENALEX_URL', 'https://api.openalex.org'),
        'api_key' => env('OPENALEX_API_KEY'),
        'per_page' => (int) env('OPENALEX_PER_PAGE', 20),
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'model' => env('OPENAI_CONTENT_MODEL', 'gpt-4o-mini'),
        'max_tokens' => (int) env('OPENAI_MAX_OUTPUT_TOKENS', 2500),
    ],

];
