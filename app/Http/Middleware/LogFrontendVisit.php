<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit_Log;
use App\Models\User;

class LogFrontendVisit
{
    public function handle(Request $request, Closure $next)
    {
        // Skip admin routes completely
        if ($request->is('admin/*')) return $next($request);

        //  Skip login page or ajax (optional but safe)
        if ($request->ajax()) return $next($request);


        $lastSegment = last(explode('/', url()->current()));


        // dd([
        //     'all' => $request->all(),
        //     'query' => $request->query(),
        //     'input' => $request->input(),
        //     'headers' => $request->headers->all(),
        //     'method' => $request->method(),
        //     'url' => $request->fullUrl(),
        //     'ip' => $request->ip(),
        //     'route' => $request->route(),
        // ]);

        // The last segment is the owner's slug (desmond-yap) or base64 id (MQ==).
        $user = User::findByRouteKey($lastSegment);

        if($user)
        {
            // log ONLY frontend
            Visit_Log::set_visit_log($user->id);
        }

        // Anything else (sitemap.xml, a mistyped URL) carries on and is
        // handled by the router, so it 404s normally instead of 403.
        return $next($request);

    }
}
