<?php

namespace App\Notifications\Shipment;

use App\Enums\NotificationType;
use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * يُرسل للأدمن عند إنشاء شحنة جديدة من قبل تاجر
 */
class ShipmentCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Shipment $shipment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $type = NotificationType::ShipmentCreated;
        $merchantName = $this->shipment->merchant?->user?->name ?? 'تاجر';

        return [
            'type' => $type->value,
            'title' => $type->title(),
            'message' => "تم إنشاء شحنة جديدة #{$this->shipment->tracking_number} من التاجر ({$merchantName})",
            'icon' => $type->icon(),
            'color' => $type->color(),
            'url' => route('admin.shipments.index'), // توجيه للأدمن لجدول الشحنات
            'shipment_id' => $this->shipment->id,
            'tracking_number' => $this->shipment->tracking_number,
        ];
    }
}
