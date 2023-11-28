<?php

namespace Modules\Persona\Services\Web\User;

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Persona\Services\Base\WebAuthenticationService;

/**
 *
 */
class ResendVerificationEmailService
{
    use WebAuthenticationService;

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        return $this->resend($request);
    }


    protected function useVendorTrait(): string
    {
        return VerifiesEmails::class;
    }
}
