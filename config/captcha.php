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

    'driver' => env('CAPTCHA_DRIVER', 'math'),

    // How long an unanswered question stays valid, in seconds.
    'lifetime' => 1800,

    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret' => env('TURNSTILE_SECRET'),
        'verify_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
    ],

];
