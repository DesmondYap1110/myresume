<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Picks the language a public page is read in.
 *
 * In order: ?lang= on the address, then what the visitor chose earlier, then
 * what their browser asks for, then the default. The choice is remembered in
 * the session so it survives moving between pages.
 */
class SetLocale
{
    public const key = 'site_locale';

    public function handle(Request $request, Closure $next): Response
    {
        $supported = array_keys((array) config('locales.supported', []));
        $default = (string) config('locales.default', 'en');

        $wanted = $request->query('lang');

        if (is_string($wanted) && in_array($wanted, $supported, true)) {
            $request->session()->put(self::key, $wanted);
            $locale = $wanted;
        } else {
            $locale = $request->session()->get(self::key)
                ?: $this->fromBrowser($request, $supported)
                ?: $default;
        }

        App::setLocale(in_array($locale, $supported, true) ? $locale : $default);

        return $next($request);
    }

    /**
     * The first language the browser asks for that we actually publish.
     *
     * Accept-Language names regions ("zh-CN", "en-GB"); we only keep the
     * language part, so zh-CN and zh-TW both land on zh.
     */
    private function fromBrowser(Request $request, array $supported): ?string
    {
        foreach ($request->getLanguages() as $language) {
            $code = strtolower(substr((string) $language, 0, 2));

            if (in_array($code, $supported, true)) {
                return $code;
            }
        }

        return null;
    }
}
