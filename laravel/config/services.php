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

    'authentik' => [
        // URL the BROWSER uses to reach Authentik (redirect, consent, logout).
        'issuer' => env('AUTHENTIK_ISSUER', 'http://localhost:9001/application/o/digital-hub/'),
        // URL THIS SERVER uses to reach Authentik over the docker network.
        // Never use localhost here: inside a container that is the container itself.
        'internal_issuer' => env('AUTHENTIK_INTERNAL_ISSUER', 'http://server:9000/application/o/digital-hub/'),
        'client_id' => env('AUTHENTIK_CLIENT_ID', ''),
        'client_secret' => env('AUTHENTIK_CLIENT_SECRET', ''),
        // Must match a Redirect URI registered on the Authentik provider,
        // and must be reachable from the browser, so keep the host-facing URL.
        'redirect_uri' => env('AUTHENTIK_REDIRECT_URI', 'http://localhost:9000/auth/callback'),
        'scope' => env('AUTHENTIK_SCOPE', 'openid email profile'),
    ],

];
