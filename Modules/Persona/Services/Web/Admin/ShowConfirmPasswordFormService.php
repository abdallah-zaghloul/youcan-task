<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;


/**
 *
 */
class ShowConfirmPasswordFormService
{
    use AdminWebAuthenticationService;

    /**
     * @return Renderable
     */
    public function render(): Renderable
    {
        return $this->showConfirmForm();
    }

    protected function useVendorTrait(): string
    {
        return ConfirmsPasswords::class;
    }
}
