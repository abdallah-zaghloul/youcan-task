<?php

namespace Modules\Persona\Http\Middleware;

use Modules\Persona\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Persona\Traits\GuardRedirectHandler;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class RedirectIfAuthenticated
{
    use GuardRedirectHandler;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (auth($guard)->check())
                return redirect(static::getGuardRedirectAttributes()->get($guard)['homePath']);
        }

        return $next($request);
    }
}
