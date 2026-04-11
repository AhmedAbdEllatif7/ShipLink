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

    /**
     * Create a new notification instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
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

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
