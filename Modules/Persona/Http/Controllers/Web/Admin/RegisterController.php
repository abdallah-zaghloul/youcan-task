<?php

namespace Modules\Persona\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Persona\Services\Web\Admin\RegistrationService;
use Modules\Persona\Services\Web\Admin\ShowRegistrationFormService;

/**
 *
 */
class RegisterController extends Controller
{

    /**
     * @param ShowRegistrationFormService $service
     * @return Renderable
     */
    public function showRegistrationForm(ShowRegistrationFormService $service): Renderable
    {
        return $service->render();
    }


    /**
     * @param RegistrationService $service
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws ValidationException
     */
    public function register(RegistrationService $service, Request $request): JsonResponse|RedirectResponse
    {
        return $service->render($request);
    }
}
