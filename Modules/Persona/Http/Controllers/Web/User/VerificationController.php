<?php

namespace Modules\Persona\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Persona\Services\Web\User\ResendVerificationEmailService;
use Modules\Persona\Services\Web\User\ShowEmailVerificationFormService;
use Modules\Persona\Services\Web\User\VerifyEmailService;

/**
 *
 */
class VerificationController extends Controller
{

    /**
     * @param ShowEmailVerificationFormService $service
     * @param Request $request
     * @return Renderable
     */
    public function show(ShowEmailVerificationFormService $service, Request $request): Renderable
    {
        return $service->render($request);
    }


    /**
     * @throws AuthorizationException
     */
    public function verify(VerifyEmailService $service, Request $request): JsonResponse|RedirectResponse
    {
        return $service->render($request);
    }


    /**
     * @param ResendVerificationEmailService $service
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function resend(ResendVerificationEmailService $service, Request $request): JsonResponse|RedirectResponse
    {
       return $service->render($request);
    }
}
