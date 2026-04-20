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
            ->subject(Lang::get('كود التحقق الخاص بك - ShipLink'))
            ->greeting(Lang::get('مرحباً، :name!', ['name' => $notifiable->name]))
            ->line(Lang::get('شكراً لتسجيلك في ShipLink. استخدم الكود التالي المكون من 6 أرقام للتحقق من عنوان بريدك الإلكتروني:'))
            ->line($this->code) // Displaying the code clearly
            ->line(Lang::get('هذا الكود صالح لمدة 15 دقيقة فقط.'))
            ->line(Lang::get('إذا لم تقم بإنشاء حساب، فلا داعي لاتخاذ أي إجراء آخر.'))
            ->salutation(Lang::get('مع أطيب التحيات،') . "\n" . config('app.name'));
    }
}
