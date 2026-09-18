<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Records that the signed-in account is still around, so an administrator can
 * see who is online. Written at most once a minute instead of on every request.
 */
class TrackLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && (!$user->last_seen_at || $user->last_seen_at->lt(now()->subMinute()))) {
            // Plain update, so updated_at keeps meaning "the profile changed".
            User::where('id', $user->id)->update(['last_seen_at' => now()]);
            $user->last_seen_at = now();
        }

        return $next($request);
    }
}
