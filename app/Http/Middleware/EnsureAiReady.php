<?php

namespace App\Http\Middleware;

use App\Models\AiSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Only an administrator configures the AI Assistant, under Admin > AI Setting.
 * Until an account has a provider and a key the module is hidden from the
 * sidebar, and this closes the door for anyone who reaches the address
 * anyway. The rule holds for administrators too: an account with nothing set
 * up has nothing to talk to.
 */
class EnsureAiReady
{
    public function handle(Request $request, Closure $next): Response
    {
        if (AiSetting::forUser(Auth::id())->isReady()) {
            return $next($request);
        }

        abort(403, 'The AI Assistant has not been set up for this account. Add a provider and key under AI Setting.');
    }
}
