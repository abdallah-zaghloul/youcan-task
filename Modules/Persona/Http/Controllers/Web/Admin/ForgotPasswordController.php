<?php

namespace Modules\Persona\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Persona\Services\Web\Admin\SendResetPasswordService;
use Modules\Persona\Services\Web\Admin\ShowForgotPasswordLinkFormService;

/**
 *
 */
class ForgotPasswordController extends Controller
{

    /**
     * @param ShowForgotPasswordLinkFormService $service
     * @return Renderable
     */
    public function showLinkRequestForm(ShowForgotPasswordLinkFormService $service): Renderable
    {
        return $service->render();
    }


    /**
     * @param SendResetPasswordService $service
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function sendResetLinkEmail(SendResetPasswordService $service, Request $request): JsonResponse|RedirectResponse
    {
        return $service->render($request);
    }
}
