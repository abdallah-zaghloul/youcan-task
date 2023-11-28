<?php

namespace Modules\Persona\Services\Web\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Modules\Persona\Traits\GuardRedirectHandler;


/**
 *
 */
class HomeService
{
    use GuardRedirectHandler;

    /**
     * @return Renderable|RedirectResponse
     */
    public function render(): Renderable|RedirectResponse
    {
//        return view(static::homeView());
        return redirect()->to(static::homePath());
    }
}
