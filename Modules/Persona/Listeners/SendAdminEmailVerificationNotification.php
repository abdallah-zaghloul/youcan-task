<?php

namespace Modules\Persona\Listeners;

use Modules\Persona\Events\AdminRegistered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdminEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param AdminRegistered $event
     * @return void
     */
    public function handle(AdminRegistered $event): void
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }
}
