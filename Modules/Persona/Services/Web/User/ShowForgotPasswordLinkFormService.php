<?php

namespace Modules\Persona\Services\Web\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Modules\Persona\Services\Base\WebAuthenticationService;

/**
 *
 */
class ShowForgotPasswordLinkFormService
{
    use WebAuthenticationService;

    /**
     * @return Renderable
     */
    public function render(): Renderable
    {
        return $this->showLinkRequestForm();
    }

    protected function useVendorTrait(): string
    {
        return SendsPasswordResetEmails::class;
    }
}
