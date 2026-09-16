<?php

/*
|--------------------------------------------------------------------------
| Contact form captcha
|--------------------------------------------------------------------------
|
| 'math'      - a small sum the visitor answers. Works offline, needs no
|               account, and is readable by screen readers.
| 'turnstile' - Cloudflare Turnstile. Stronger, invisible to most visitors,
|               but needs a free site key and secret.
| 'none'      - off (the honeypot, time trap and rate limit still apply).
|
*/

return [

    /*
    | Left unset, the driver follows the environment: Turnstile in production,
    | the sum question everywhere else. Set CAPTCHA_DRIVER in .env to force
    | one ('turnstile', 'math' or 'none').
    */
    'driver' => env('CAPTCHA_DRIVER') ?: (env('APP_ENV') === 'production' ? 'turnstile' : 'math'),

    // How long an unanswered question stays valid, in seconds.
    'lifetime' => 1800,

    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret' => env('TURNSTILE_SECRET'),
        'verify_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
    ],

];
