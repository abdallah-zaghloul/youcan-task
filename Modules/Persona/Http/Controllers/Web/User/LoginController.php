<?php

namespace Modules\Persona\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\Persona\Services\Web\User\LoginService;
use Modules\Persona\Services\Web\User\LogoutService;
use Modules\Persona\Services\Web\User\ShowLoginFormService;

/**
 *
 */
class LoginController extends Controller
{

    /**
     * @param ShowLoginFormService $service
     * @return Renderable
     */
    public function showLoginForm(ShowLoginFormService $service): Renderable
    {
        return $service->render();
    }


    /**
     * @throws ValidationException
     */
    public function login(LoginService $service, Request $request): Response|JsonResponse|RedirectResponse
    {
        return $service->render($request);
    }


    /**
     * @param LogoutService $service
     * @param Request $request
     * @return Response|JsonResponse|RedirectResponse
     */
    public function logout(LogoutService $service, Request $request): Response|JsonResponse|RedirectResponse
    {
        return $service->render($request);
    }
}
