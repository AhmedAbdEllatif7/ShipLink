<?php

namespace App\Notifications\Shipment;

use App\Enums\NotificationType;
use App\Enums\ShipmentStatus;
use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * يُرسل للأدمن والتاجر عند تغيير حالة الشحنة من قبل السائق
 */
class ShipmentStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Shipment $shipment,
        public ShipmentStatus $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array{type: string, title: string, message: string, icon: string, color: string, url: string, shipment_id: int, tracking_number: string, new_status: string, new_status_label: string}
     */
    public function toArray(object $notifiable): array
    {
        $type = NotificationType::ShipmentStatusChanged;

        return [
            'type' => $type->value,
            'title' => $type->title(),
            'message' => "تم تحديث حالة الشحنة #{$this->shipment->tracking_number} إلى ({$this->newStatus->label()})",
            'icon' => $type->icon(),
            'color' => $type->color(),
            'url' => match($notifiable->type->value ?? 'admin') {
                'merchant' => route('merchant.shipments.show', $this->shipment->id),
                'driver' => route('driver.shipments.show', $this->shipment->id),
                default => route('admin.shipments.show', $this->shipment->id),
            },
            'shipment_id' => $this->shipment->id,
            'tracking_number' => $this->shipment->tracking_number,
            'new_status' => $this->newStatus->value,
            'new_status_label' => $this->newStatus->label(),
        ];
    }
}
