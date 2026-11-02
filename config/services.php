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

    /*
    |--------------------------------------------------------------------------
    | PostHog
    |--------------------------------------------------------------------------
    |
    | El Project API Key (phc_...) es una clave pública pensada para el
    | cliente. Nunca debe colocarse aquí una Personal API Key (phx_...) ni
    | un Project Secret (phs_...).
    |
    */

    'posthog' => [
        'project_token' => env('POSTHOG_PROJECT_TOKEN'),
        'host' => env('POSTHOG_HOST', 'https://us.i.posthog.com'),
        'experiment_key' => env('POSTHOG_EXPERIMENT_KEY', 'repuestos-vargas-header-ab'),
        'environment' => env('POSTHOG_ENVIRONMENT', env('APP_ENV', 'production')),
        'test_environment' => env('POSTHOG_TEST_ENVIRONMENT'),
    ],

];
