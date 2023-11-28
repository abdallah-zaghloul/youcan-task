<?php

namespace Modules\Persona\Services\Web\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Persona\Services\Base\WebAuthenticationService;

/**
 *
 */
class ShowLoginFormService
{
    use WebAuthenticationService;

    /**
     * @return Renderable
     */
    public function render(): Renderable
    {
        return view('persona::user.login');
    }


    protected function useVendorTrait(): string
    {
        return AuthenticatesUsers::class;
    }
}
