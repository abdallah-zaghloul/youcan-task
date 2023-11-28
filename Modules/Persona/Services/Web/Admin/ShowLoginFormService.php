<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;


/**
 *
 */
class ShowLoginFormService
{
    use AdminWebAuthenticationService;

    /**
     * @return Renderable
     */
    public function render(): Renderable
    {
        return view('persona::admin.login');
    }


    protected function useVendorTrait(): string
    {
        return AuthenticatesUsers::class;
    }
}
