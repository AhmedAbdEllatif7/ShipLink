<?php

namespace App\Notifications\Wallet;

use App\Enums\NotificationType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * يُرسل للتاجر أو المندوب عند إيداع مبلغ في محفظته من قبل الأدمن
 */
class WalletDepositNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param  float  $amount  المبلغ المودع
     * @param  string  $currency  العملة
     * @param  string|null  $description  وصف العملية
     */
    public function __construct(
        public float $amount,
        public string $currency = 'QAR',
        public ?string $description = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array{type: string, title: string, message: string, icon: string, color: string, url: string, amount: float, currency: string}
     */
    public function toArray(object $notifiable): array
    {
        $type = NotificationType::WalletDeposit;
        $formattedAmount = number_format($this->amount, 2);

        return [
            'type' => $type->value,
            'title' => $type->title(),
            'message' => "تم إيداع مبلغ {$formattedAmount} {$this->currency} في محفظتك".($this->description ? " - {$this->description}" : ''),
            'icon' => $type->icon(),
            'color' => $type->color(),
            'url' => '#', // سيتم تحديثه عند بناء صفحة المحفظة
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
