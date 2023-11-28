<?php

namespace Modules\Persona\Http\Controllers\Web;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Persona\Services\Web\WelcomeService;

/**
 *
 */
class WelcomeController extends Controller
{

    /**
     * @param WelcomeService $service
     * @return Renderable
     */
    public function __invoke(WelcomeService $service): Renderable
    {
        return $service->render();
    }
}
