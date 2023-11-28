<?php

namespace Modules\Persona\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Modules\Persona\Traits\GuardRedirectHandler;

/**
 *
 */
class Authenticate extends Middleware
{
    use GuardRedirectHandler;

    protected ?string $route = null;
    protected array $guards;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;
        $this->authenticate($request, $guards);
        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()){
            $guardRedirectAttributes = static::getGuardRedirectAttributes();
            $requestPathMatchedHome = $guardRedirectAttributes->pluck('loginRoute','homePath')->get($request->path());
            count($this->guards) === 1 and $loginRoute = @$guardRedirectAttributes->get(head($this->guards))['loginRoute'];
            $this->route = route($requestPathMatchedHome ?? $loginRoute ?? 'login');
        }

        return $this->route;
    }
}
