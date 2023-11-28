<?php

namespace Modules\Persona\Traits;

use Illuminate\Support\Collection;
use Modules\Persona\Providers\RouteServiceProvider;

trait GuardRedirectHandler
{
    /**
     * @return Collection
     */
    public static function getGuardRedirectAttributes(): Collection
    {
        return collect([
            'web' => [
                'shouldVerifyEmail' => env('SHOULD_VERIFY_USER_EMAIL', false),
                'VerificationNoticeRoute' => 'verification.notice',
                'loginRoute' => 'login',
                'homePath' => RouteServiceProvider::USER_HOME,
                'homeView' => 'persona::user.home',
            ],
            'adminWeb' => [
                'shouldVerifyEmail' => env('SHOULD_VERIFY_ADMIN_EMAIL', false),
                'VerificationNoticeRoute' => 'adminWeb.verification.notice',
                'loginRoute' => 'adminWeb.login',
                'homePath' => RouteServiceProvider::ADMIN_HOME,
                'homeView' => 'persona::admin.home',
            ],
        ]);
    }

    public static function getGuard(): ?string
    {
        return static::getGuardRedirectAttributes()->keys()->firstWhere(fn($guard) => auth($guard)->check());
    }

    public static function homePath()
    {
        return static::getGuardRedirectAttributes()->dot()->get(static::getGuard().".homePath");
    }

    public static function homeView()
    {
        return static::getGuardRedirectAttributes()->dot()->get(static::getGuard().".homeView");
    }
}
