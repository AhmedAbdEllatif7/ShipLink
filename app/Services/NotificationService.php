<?php

namespace App\Services;

use App\Enums\ShipmentStatus;
use App\Enums\UserType;
use App\Models\Shipment;
use App\Models\User;
use App\Notifications\Shipment\DriverAssignedNotification;
use App\Notifications\Shipment\ShipmentCreatedNotification;
use App\Notifications\Shipment\ShipmentStatusChangedNotification;
use App\Notifications\Wallet\WalletDepositNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * إشعار الأدمن عند إنشاء شحنة جديدة من قبل تاجر
     */
    public function notifyAdminsOfNewShipment(Shipment $shipment): void
    {
        // استخدام chunkById لضمان أداء عالٍ حتى لو عدد الأدمنز كبير جداً
        User::where('type', UserType::ADMIN)->chunkById(100, function ($admins) use ($shipment) {
            Notification::send($admins, new ShipmentCreatedNotification($shipment));
        });
    }

    /**
     * إشعار السائق عند تكليفه بشحنة
     */
    public function notifyDriverOfAssignment(Shipment $shipment): void
    {
        $driverUser = $shipment->driver?->user;

        if (! $driverUser) {
            return;
        }

        $driverUser->notify(new DriverAssignedNotification($shipment));
    }

    /**
     * إشعار الأدمن والتاجر عند تغيير حالة الشحنة من قبل السائق
     */
    public function notifyStatusChange(Shipment $shipment, ShipmentStatus $newStatus): void
    {
        // 1. إشعار التاجر صاحب الشحنة (فردي - سريع)
        $merchantUser = $shipment->merchant?->user;
        if ($merchantUser) {
            $merchantUser->notify(new ShipmentStatusChangedNotification($shipment, $newStatus));
        }

        // 2. إشعار جميع الأدمن (بالتدريج لتقليل استهلاك الرامات)
        User::where('type', UserType::ADMIN)->chunkById(100, function ($admins) use ($shipment, $newStatus) {
            Notification::send($admins, new ShipmentStatusChangedNotification($shipment, $newStatus));
        });
    }

    /**
     * إشعار المستخدم (تاجر أو مندوب) عند إيداع مبلغ في محفظته
     */
    public function notifyWalletDeposit(User $user, float $amount, string $currency = 'QAR', ?string $description = null): void
    {
        $user->notify(new WalletDepositNotification($amount, $currency, $description));
    }
}
