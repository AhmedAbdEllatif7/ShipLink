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
            ->subject(Lang::get('كود التحقق الخاص بك - ShipLink'))
            ->greeting(Lang::get('مرحباً!'))
            ->line(Lang::get('لقد تلقيت هذا البريد الإلكتروني لأنك طلبت التسجيل في ShipLink.'))
            ->line(Lang::get('استخدم الكود التالي المكون من 6 أرقام للتحقق من عنوان بريدك الإلكتروني:'))
            ->line($this->code)
            ->line(Lang::get('هذا الكود صالح لمدة 15 دقيقة فقط.'))
            ->line(Lang::get('إذا لم تقم بطلب هذا الكود، فلا داعي لاتخاذ أي إجراء آخر.'))
            ->salutation(Lang::get('مع أطيب التحيات،') . "\n" . config('app.name'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
