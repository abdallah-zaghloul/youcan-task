<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\RegistersUsers;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;

/**
 *
 */
class ShowRegistrationFormService
{
    use AdminWebAuthenticationService;

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
