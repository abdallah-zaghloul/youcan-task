<?php

namespace Modules\Persona\Services\Web\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Modules\Persona\Services\Base\WebAuthenticationService;

/**
 *
 */
class ShowConfirmPasswordFormService
{
    use WebAuthenticationService;

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
