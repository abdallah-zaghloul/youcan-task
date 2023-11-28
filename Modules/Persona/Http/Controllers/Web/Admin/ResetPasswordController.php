<?php

namespace Modules\Persona\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Persona\Services\Web\Admin\ResetPasswordFormService;
use Modules\Persona\Services\Web\Admin\ResetPasswordService;

/**
 *
 */
class ResetPasswordController extends Controller
{

    /**
     * @param ResetPasswordFormService $service
     * @param Request $request
     * @return Renderable
     */
    public function showResetForm(ResetPasswordFormService $service, Request $request): Renderable
    {
        return $service->render($request);
    }


    /**
     * @param ResetPasswordService $service
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function reset(ResetPasswordService $service, Request $request): JsonResponse|RedirectResponse
    {
        return $service->render($request);
    }

}
