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
    // Browser-facing issuer. Used only to build the authorize redirect.
    'issuer' => env('AUTHENTIK_ISSUER', 'http://localhost:9001/application/o/digital-hub/'),

    // Endpoints this server calls. They are NOT nested under the issuer's
    // application slug, so they are configured explicitly instead of being
    // derived from it.
    'internal_issuer' => env('AUTHENTIK_INTERNAL_ISSUER', 'http://server:9000/application/o/'),
    'authorize_endpoint' => env('AUTHENTIK_AUTHORIZE_ENDPOINT', 'http://localhost:9001/application/o/authorize/'),
    'token_endpoint' => env('AUTHENTIK_TOKEN_ENDPOINT', 'http://server:9000/application/o/token/'),
    'userinfo_endpoint' => env('AUTHENTIK_USERINFO_ENDPOINT', 'http://server:9000/application/o/userinfo/'),
    'introspect_endpoint' => env('AUTHENTIK_INTROSPECT_ENDPOINT', 'http://server:9000/application/o/introspect/'),
        'revoke_endpoint' => env('AUTHENTIK_REVOKE_ENDPOINT', 'http://server:9000/application/o/revoke/'),
    'end_session_endpoint' => env('AUTHENTIK_END_SESSION_ENDPOINT', 'http://localhost:9001/application/o/digital-hub/end-session/'),

    'client_id' => env('AUTHENTIK_CLIENT_ID', ''),
        'client_secret' => env('AUTHENTIK_CLIENT_SECRET', ''),

        // Custom Vue IdP UI that replaces Authentik's built-in flow pages.
        // Served by nginx under /idp on the SAME origin/port as the app
        // (:8080), so the session cookie is first-party. The app is also
        // reachable on :9000 but that is php-fpm directly (no nginx), which
        // would NOT carry /idp - so the app itself is used on :8080.
        // Leave empty to fall back to the built-in interface.
        'spa_url' => env('AUTHENTIK_SPA_URL', 'http://localhost:8080/idp'),

    // Must match a Redirect URI registered on the provider AND be reachable
    // by the browser, so this one stays host-facing.
    'redirect_uri' => env('AUTHENTIK_REDIRECT_URI', 'http://localhost:9000/auth/callback'),
    'scope' => env('AUTHENTIK_SCOPE', 'openid email profile'),
],

];
