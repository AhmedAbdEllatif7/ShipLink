<?php

namespace App\Observers;

use App\Enums\ShipmentStatus;
use App\Enums\UserType;
use App\Models\Shipment;
use App\Models\ShipmentStatusHistory;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShipmentObserver
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function creating(Shipment $shipment): void
    {
        if (empty($shipment->tracking_number)) {
            $shipment->tracking_number = $this->generateUniqueTrackingNumber();
        }

        if (empty($shipment->status)) {
            $shipment->status = ShipmentStatus::PENDING;
        }
    }

    public function created(Shipment $shipment): void
    {
        $this->logStatusHistory($shipment, 'تم إنشاء الشحنة');

        // إشعار جميع الأدمن بالشحنة الجديدة
        $this->notificationService->notifyAdminsOfNewShipment($shipment);
    }

    public function updating(Shipment $shipment): void
    {
        // منع تعديل الشحنة إذا كانت وصلت بالفعل
        if ($shipment->isDirty('status') && $shipment->getOriginal('status') === ShipmentStatus::DELIVERED) {
            throw new \DomainException('لا يمكن تعديل حالة شحنة تم توصيلها بالفعل.');
        }

        if ($shipment->isDirty('status')) {
            if ($shipment->status === ShipmentStatus::DELIVERED) {
                $shipment->delivered_at = now();
            }

            if ($shipment->status === ShipmentStatus::ASSIGNED) {
                $shipment->assigned_at = now();
            }
        }
    }

    public function updated(Shipment $shipment): void
    {
        if ($shipment->isDirty('status')) {
            $notes = $shipment->status_notes;

            if ($shipment->status === ShipmentStatus::ASSIGNED && empty($notes)) {
                $notes = 'تم تعيين السائق ('.$shipment->driver->user->name.') بواسطة الإدارة وبانتظار استلام الشحنة.';
            }

            $this->logStatusHistory($shipment, $notes);

            // إشعار السائق عند تكليفه بشحنة
            if ($shipment->status === ShipmentStatus::ASSIGNED && $shipment->isDirty('driver_id')) {
                $this->notificationService->notifyDriverOfAssignment($shipment);
            }

            // إشعار الأدمن والتاجر عند تغيير حالة الشحنة من قبل السائق
            $currentUser = Auth::user();
            if ($currentUser && $currentUser->type === UserType::DRIVER && $shipment->status !== ShipmentStatus::ASSIGNED) {
                $this->notificationService->notifyStatusChange($shipment, $shipment->status);
            }
        }
    }

    protected function generateUniqueTrackingNumber(): string
    {
        $prefix = 'SHP-';
        do {
            $trackingNumber = $prefix.strtoupper(Str::random(10));
        } while (Shipment::where('tracking_number', $trackingNumber)->exists());

        return $trackingNumber;
    }

    protected function logStatusHistory(Shipment $shipment, ?string $notes = null): void
    {
        ShipmentStatusHistory::create([
            'shipment_id' => $shipment->id,
            'status' => $shipment->status,
            'changed_by' => Auth::id(),
            'notes' => $notes,
        ]);
    }

    public function deleted(Shipment $shipment): void
    {
        if ($shipment->isForceDeleting()) {
            // حذف سجل الحالة نهائياً إذا تم حذف الشحنة نهائياً من الداتابيز
            $shipment->statusHistories()->delete();
        } else {
            // تسجيل عملية الحذف في الهيستوري (لأن الموديل يستخدم SoftDeletes)
            $this->logStatusHistory($shipment, 'تم نقل الشحنة إلى سلة المهملات');
        }
    }
}
