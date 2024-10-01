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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id'     => '670256087857-ua1mvsd398897040v1t5llf7t1ttevhj.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect'      => 'https://gomeal-qa.inheritxdev.in/google/auth/callback',
    ],
    'google_place_key' => 'AIzaSyAK9hxj_YCu51y0dBZfRz2jHkUOb8sY3cw',

];
