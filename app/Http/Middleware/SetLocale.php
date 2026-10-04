<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Picks the language a public page is read in.
 *
 * In order: ?lang= on the address, then what the visitor chose earlier, then
 * the language the site owner set under Profile, then what the visitor's
 * browser asks for, then the default. The choice is remembered in the session
 * so it survives moving between pages.
 *
 * The owner's setting sits above the browser on purpose: it is the language
 * they wrote the site in. A visitor who switches still wins, because their
 * choice is in the session and is read first.
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
                ?: $this->fromOwner($request, $supported)
                ?: $this->fromBrowser($request, $supported)
                ?: $default;
        }

        App::setLocale(in_array($locale, $supported, true) ? $locale : $default);

        return $next($request);
    }

    /**
     * What the owner of the site being viewed chose under Profile.
     *
     * The public routes all carry the owner's slug as {id}. Admin pages have
     * no such parameter, so this costs nothing there - and the query only runs
     * when the visitor has neither asked for a language nor chosen one before.
     */
    private function fromOwner(Request $request, array $supported): ?string
    {
        $slug = $request->route('id');

        if (!is_string($slug) || $slug === '') {
            return null;
        }

        $locale = User::where('slug', $slug)->value('default_locale');

        return is_string($locale) && in_array($locale, $supported, true) ? $locale : null;
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
