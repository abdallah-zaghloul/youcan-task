<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;


/**
 *
 */
class VerifyEmailService
{
    use AdminWebAuthenticationService;

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        return $this->verify($request);
    }

    protected function useVendorTrait(): string
    {
        return VerifiesEmails::class;
    }
}
