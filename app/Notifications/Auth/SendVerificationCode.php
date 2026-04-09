<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class SendVerificationCode extends Notification implements ShouldQueue
{
    use Queueable;

    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }


    public function via($notifiable): array
    {
        return ['mail'];
    }


    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Your Verification Code - ShipLink'))
            ->greeting(Lang::get('Hello, :name!', ['name' => $notifiable->name]))
            ->line(Lang::get('Thank you for registering with ShipLink. Use the following 6-digit code to verify your email address:'))
            ->line($this->code) // Displaying the code clearly
            ->line(Lang::get('This code will expire in 15 minutes.'))
            ->line(Lang::get('If you did not create an account, no further action is required.'))
            ->salutation(Lang::get('Best regards,') . "\n" . config('app.name'));
    }
}
