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
            ];

            // Post pages exist on templates that have them; the others redirect here.
            foreach ($posts as $post) {
                $urls[] = [
                    'loc' => $base.'/post/'.$post->id.'/'.$key,
                    'lastmod' => optional($post->updated_at)->toAtomString(),
                    'priority' => '0.8',
                    'changefreq' => 'monthly',
                ];
            }
        }

        $xml = view('website.sitemap', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
