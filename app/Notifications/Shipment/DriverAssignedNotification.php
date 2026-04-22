<?php

namespace App\Notifications\Shipment;

use App\Enums\NotificationType;
use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * يُرسل للسائق عند تكليفه بشحنة من قبل الأدمن
 */
class DriverAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Shipment $shipment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array{type: string, title: string, message: string, icon: string, color: string, url: string, shipment_id: int, tracking_number: string}
     */
    public function toArray(object $notifiable): array
    {
        $type = NotificationType::DriverAssigned;

        return [
            'type' => $type->value,
            'title' => $type->title(),
            'message' => "تم تكليفك بشحنة جديدة #{$this->shipment->tracking_number} إلى ({$this->shipment->receiver_name})",
            'icon' => $type->icon(),
            'color' => $type->color(),
            'url' => route('driver.shipments.index'), // توجيه مباشر للسائق
            'shipment_id' => $this->shipment->id,
            'tracking_number' => $this->shipment->tracking_number,
        ];
    }
}
