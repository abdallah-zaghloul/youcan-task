<?php

namespace Modules\Persona\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified as BaseEnsureEmailIsVerified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Modules\Persona\Traits\GuardRedirectHandler;

/**
 *
 */
class EnsureEmailIsVerified extends BaseEnsureEmailIsVerified
{
    use GuardRedirectHandler;
    protected Collection $guardRedirectAttributesDotted;
    protected ?string $guard;

    public function __construct()
    {
        $this->guardRedirectAttributesDotted = static::getGuardRedirectAttributes()->dot();
        $this->guard = static::getGuard();
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $redirectToRoute
     * @return Response|RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null): Response|RedirectResponse|null
    {
        return match ($this->shouldVerifyEmail($request)){
            true => $this->redirectAccTo($request, $redirectToRoute),
            default => $next($request)
        };
    }


    /**
     * @param $request
     * @param $redirectToRoute
     * @return RedirectResponse
     */
    protected function redirectAccTo($request, $redirectToRoute = null): RedirectResponse
    {
        return $request->expectsJson()
            ? abort(403, 'Your email address is not verified.')
            : Redirect::guest(URL::route($redirectToRoute ?? $this->guardRedirectAttributesDotted->get("$this->guard.VerificationNoticeRoute")));
    }


    /**
     * @param $request
     * @return bool
     */
    protected function shouldVerifyEmail($request): bool
    {
        return ! ($user = $request->user($this->guard)) or collect([
                $this->guardRedirectAttributesDotted->get("$this->guard.shouldVerifyEmail"),
                $user instanceof MustVerifyEmail,
                ! $user->hasVerifiedEmail()
        ])->every(fn($condition) => $condition === true);
    }
}
