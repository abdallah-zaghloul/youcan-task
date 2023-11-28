<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;


/**
 *
 */
class SendResetPasswordService
{

    use AdminWebAuthenticationService;

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        return $this->sendResetLinkEmail($request);
    }

    protected function useVendorTrait(): string
    {
        return SendsPasswordResetEmails::class;
    }
}
