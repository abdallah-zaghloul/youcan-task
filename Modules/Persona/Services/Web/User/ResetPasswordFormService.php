<?php

namespace Modules\Persona\Services\Web\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Modules\Persona\Services\Base\WebAuthenticationService;

/**
 *
 */
class ResetPasswordFormService
{
    use WebAuthenticationService;

    /**
     * @param Request $request
     * @return Renderable
     */
    public function render(Request $request): Renderable
    {
        return $this->showResetForm($request);
    }

    protected function useVendorTrait(): string
    {
        return ResetsPasswords::class;
    }
}
