<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Response;

/**
 * /sitemap.xml - every public portfolio and blog post, so search engines
 * can find them without crawling link by link.
 */
class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = rtrim((string) config('app.url'), '/');
        $urls = [];

        $users = User::where('status', User::status_active)->get();

        foreach ($users as $user) {
            $key = $user->routeKey();
            $posts = Blog::getBlogByUserid($user->id);

            $urls[] = [
                'loc' => $base.'/'.$key,
                'lastmod' => optional($posts->max('updated_at') ?: $user->updated_at)->toAtomString(),
                'priority' => '1.0',
                'changefreq' => 'weekly',
                'alternates' => $this->alternates($base.'/'.$key),
            ];

            // Post pages exist on templates that have them; the others redirect here.
            foreach ($posts as $post) {
                $urls[] = [
                    'loc' => $base.'/post/'.$post->id.'/'.$key,
                    'lastmod' => optional($post->updated_at)->toAtomString(),
                    'priority' => '0.8',
                    'changefreq' => 'monthly',
                    'alternates' => $this->alternates($base.'/post/'.$post->id.'/'.$key),
                ];
            }
        }

        $xml = view('website.sitemap', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /**
     * The same page in each language.
     *
     * Google has no session, so without naming the translated addresses here
     * it would only ever see the default language and the translations would
     * never be indexed.
     *
     * @return array<int, array{hreflang: string, href: string}>
     */
    private function alternates(string $url): array
    {
        $default = (string) config('locales.default', 'en');
        $out = [];

        foreach (array_keys((array) config('locales.supported', [])) as $locale) {
            $out[] = [
                'hreflang' => $locale,
                'href' => $locale === $default ? $url : $url.'?lang='.$locale,
            ];
        }

        $out[] = ['hreflang' => 'x-default', 'href' => $url];

        return $out;
    }
}
