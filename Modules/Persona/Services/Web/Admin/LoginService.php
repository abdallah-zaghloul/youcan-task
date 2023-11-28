<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;

/**
 *
 */
class LoginService
{
    use AdminWebAuthenticationService;

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Response
     * @throws ValidationException
     */
    public function render(Request $request): JsonResponse|RedirectResponse|Response
    {
        return $this->login($request);
    }

    protected function useVendorTrait(): string
    {
        return AuthenticatesUsers::class;
    }
}
