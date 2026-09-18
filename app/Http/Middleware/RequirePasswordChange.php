<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

/**
 * The first administrator is created with the password from config/admin.php,
 * which is in the repository and therefore public. While that password is
 * still in use, the back office leads to Account Setting and nowhere else.
 */
class RequirePasswordChange
{
    /** Pages reachable while the password is still the default one. */
    private const allowed = ['setting.view', 'setting.update', 'login.logout'];

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || in_array($request->route()?->getName(), self::allowed, true)) {
            return $next($request);
        }

        if (!$this->usesDefaultPassword($user)) {
            return $next($request);
        }

        return redirect()->to(route('setting.view').'#password')
            ->with('error', 'Please set your own password before using the back office. The one from installation is public.');
    }

    private function usesDefaultPassword($user): bool
    {
        $default = (string) config('admin.password');

        return $default !== '' && Hash::check($default, (string) $user->password);
    }
}
