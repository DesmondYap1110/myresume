<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

/**
 * Keeps bots out of the public contact form without a third-party captcha:
 *
 *  1. Honeypot  - a field people never see; bots fill it in.
 *  2. Time trap - a signed timestamp; a form sent within seconds is a script.
 *  3. Rate limit - a cap per IP address, so nobody can flood the inbox.
 *
 * Submissions are also stripped of HTML so nothing scriptable is ever stored.
 */
class SpamGuard
{
    /** Hidden field a real person never fills in. */
    public const honeypot = 'website_url';

    /** Hidden field carrying the signed render time. */
    public const timestamp = 'form_started';

    /** A person needs at least this many seconds to fill the form. */
    public const minSeconds = 3;

    /** A form older than this is stale (page left open for hours). */
    public const maxSeconds = 7200;

    /** Messages allowed per IP address per hour. */
    public const maxPerHour = 5;

    /** The value for the hidden timestamp field. */
    public static function token(): string
    {
        return Crypt::encryptString((string) time());
    }

    /**
     * Throws a validation error when the request looks automated.
     */
    public static function check(Request $request, string $field = 'description'): void
    {
        $fail = fn (string $message) => throw ValidationException::withMessages([$field => $message]);

        // 1. Honeypot
        if (filled($request->input(self::honeypot))) {
            Log::info('Contact form blocked: honeypot filled', ['ip' => $request->ip()]);
            $fail('Your message could not be sent. Please try again.');
        }

        // 2. Time trap
        $started = null;

        try {
            $started = (int) Crypt::decryptString((string) $request->input(self::timestamp));
        } catch (\Throwable) {
            $started = null;
        }

        if (!$started) {
            $fail('Your message could not be sent. Please reload the page and try again.');
        }

        $age = time() - $started;

        if ($age < self::minSeconds) {
            Log::info('Contact form blocked: submitted too fast', ['ip' => $request->ip(), 'seconds' => $age]);
            $fail('That was too quick. Please take a moment and send again.');
        }

        if ($age > self::maxSeconds) {
            $fail('This form has expired. Please reload the page and try again.');
        }

        // 3. Rate limit per IP
        $key = 'contact:'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, self::maxPerHour)) {
            $minutes = (int) ceil(RateLimiter::availableIn($key) / 60);
            $fail('You have sent several messages already. Please try again in '.max(1, $minutes).' minutes.');
        }

        RateLimiter::hit($key, 3600);
    }

    /**
     * Plain text only: HTML tags and control characters are removed, so a
     * message can never carry a script into the admin.
     */
    public static function clean(?string $value, int $limit = 5000): string
    {
        $value = strip_tags((string) $value);
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = strip_tags($value);                                  // in case entities hid a tag
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
        $value = preg_replace("/(\r\n|\r)/", "\n", $value);
        $value = preg_replace("/\n{3,}/", "\n\n", $value);

        return mb_substr(trim($value), 0, $limit);
    }
}
