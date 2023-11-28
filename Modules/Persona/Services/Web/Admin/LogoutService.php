<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;

/**
 *
 */
class LogoutService
{
    use AdminWebAuthenticationService;

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Response
     */
    public function render(Request $request): JsonResponse|RedirectResponse|Response
    {
        return $this->logout($request);
    }

    protected function useVendorTrait(): string
    {
        return AuthenticatesUsers::class;
    }
}
