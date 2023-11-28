<?php

namespace Modules\Persona\Services\Web\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Modules\Persona\Services\Base\AdminWebAuthenticationService;


/**
 *
 */
class ShowEmailVerificationFormService
{
    use AdminWebAuthenticationService;

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
