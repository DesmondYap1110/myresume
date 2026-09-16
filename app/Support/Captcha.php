<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Captcha for the public contact form.
 *
 * Default driver is 'math': a small sum whose answer is kept in the session,
 * so it needs no third-party account and stays readable by screen readers.
 * Set CAPTCHA_DRIVER=turnstile with Cloudflare keys for a stronger check.
 */
class Captcha
{
    public const field = 'captcha_answer';
    private const sessionKey = 'captcha.math';

    public static function driver(): string
    {
        $driver = (string) config('captcha.driver', 'math');

        // Turnstile without keys would lock the form; fall back to the sum.
        if ($driver === 'turnstile' && blank(config('captcha.turnstile.site_key'))) {
            return 'math';
        }

        return $driver;
    }

    /**
     * A fresh question, e.g. ['question' => 'What is 7 plus 4?', ...].
     */
    public static function question(): array
    {
        $a = random_int(1, 9);
        $b = random_int(1, 9);

        session([self::sessionKey => ['answer' => $a + $b, 'at' => time()]]);

        return [
            'a' => $a,
            'b' => $b,
            'question' => "What is {$a} plus {$b}?",
        ];
    }

    /**
     * Checks the answer and throws a validation error when it is wrong.
     */
    public static function validate(Request $request, string $field = self::field): void
    {
        $fail = fn (string $message) => throw ValidationException::withMessages([$field => $message]);

        match (self::driver()) {
            'none' => null,
            'turnstile' => self::verifyTurnstile($request, $fail),
            default => self::verifyMath($request, $fail),
        };
    }

    private static function verifyMath(Request $request, callable $fail): void
    {
        $stored = session(self::sessionKey);
        session()->forget(self::sessionKey);          // one attempt per question

        if (!is_array($stored) || !isset($stored['answer'])) {
            $fail('Please answer the question again.');
        }

        if (time() - (int) ($stored['at'] ?? 0) > (int) config('captcha.lifetime', 1800)) {
            $fail('That question expired. Please answer the new one.');
        }

        $given = trim((string) $request->input(self::field));

        if ($given === '' || !is_numeric($given) || (int) $given !== (int) $stored['answer']) {
            Log::info('Contact form blocked: wrong captcha answer', ['ip' => $request->ip()]);
            $fail('That answer was not correct. Please answer the new question shown above.');
        }
    }

    private static function verifyTurnstile(Request $request, callable $fail): void
    {
        $token = (string) $request->input('cf-turnstile-response');

        if ($token === '') {
            $fail('Please complete the verification.');
        }

        try {
            $response = Http::asForm()->timeout(10)->post((string) config('captcha.turnstile.verify_url'), [
                'secret' => (string) config('captcha.turnstile.secret'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            $passed = $response->successful() && ($response->json('success') === true);
        } catch (\Throwable $e) {
            Log::warning('Turnstile verification failed to run', ['error' => $e->getMessage()]);
            $passed = false;
        }

        if (!$passed) {
            Log::info('Contact form blocked: Turnstile rejected', ['ip' => $request->ip()]);
            $fail('Verification did not pass. Please try again.');
        }
    }
}
