<?php

namespace Modules\Persona\Notifications;
use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{

    /**
     * The password reset routeName.
     *
     * @var string
     */
    public string $routeName;

    public function __construct($token, string $routeName)
    {
        parent::__construct($token);
        $this->routeName = $routeName;
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function resetUrl($notifiable): string
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        //default is 'password.reset'
        return url(route($this->routeName, [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
