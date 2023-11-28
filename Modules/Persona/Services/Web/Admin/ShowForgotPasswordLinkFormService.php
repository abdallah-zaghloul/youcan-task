<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;


/**
 *
 */
class ShowForgotPasswordLinkFormService
{
    use AdminWebAuthenticationService;

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
