<?php

namespace Modules\Persona\Services\Web\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Modules\Persona\Services\Base\WebAuthenticationService;

/**
 *
 */
class ShowEmailVerificationFormService
{
    use WebAuthenticationService;

    /**
     * @param Request $request
     * @return Renderable
     */
    public function render(Request $request): Renderable
    {
        return $this->show($request);
    }

    protected function useVendorTrait(): string
    {
        return VerifiesEmails::class;
    }
}
