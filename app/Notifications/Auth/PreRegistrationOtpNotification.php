<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class PreRegistrationOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Your Pre-Registration Code - ShipLink'))
            ->greeting(Lang::get('Hello!'))
            ->line(Lang::get('You are receiving this email because you requested to register with ShipLink.'))
            ->line(Lang::get('Use the following 6-digit code to verify your email address:'))
            ->line($this->code)
            ->line(Lang::get('This code will expire in 15 minutes.'))
            ->line(Lang::get('If you did not request this, no further action is required.'))
            ->salutation(Lang::get('Best regards,') . "\n" . config('app.name'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
