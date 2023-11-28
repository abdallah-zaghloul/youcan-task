<?php

namespace Modules\Persona\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Modules\Persona\Services\Web\User\HomeService;

/**
 *
 */
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param HomeService $service
     * @return Renderable|RedirectResponse
     */
    public function index(HomeService $service): Renderable|RedirectResponse
    {
        return $service->render();
    }
}
