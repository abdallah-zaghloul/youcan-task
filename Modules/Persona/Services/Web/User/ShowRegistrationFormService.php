<?php

namespace Modules\Persona\Services\Web\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\RegistersUsers;
use Modules\Persona\Services\Base\WebAuthenticationService;

/**
 *
 */
class ShowRegistrationFormService
{
    use WebAuthenticationService;

    /**
     * @return Renderable
     */
    public function render(): Renderable
    {
        return $this->showRegistrationForm();
    }

    protected function useVendorTrait(): string
    {
        return RegistersUsers::class;
    }
}
