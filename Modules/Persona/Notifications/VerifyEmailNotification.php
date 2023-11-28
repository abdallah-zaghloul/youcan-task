<?php

namespace Modules\Persona\Notifications;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailNotification extends VerifyEmail
{
    public string $routeName;

    public function __construct(string $routeName)
    {
        $this->routeName = $routeName;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        if (static::$createUrlCallback)
            return call_user_func(static::$createUrlCallback, $notifiable);

        //default is 'verification.verify'
        return URL::temporarySignedRoute(
            $this->routeName,
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
