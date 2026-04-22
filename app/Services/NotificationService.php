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
        $admins = User::where('type', UserType::ADMIN)->get();

        if ($admins->isEmpty()) {
            return;
        }

        Notification::send($admins, new ShipmentCreatedNotification($shipment));
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
        $recipients = collect();

        // إشعار التاجر صاحب الشحنة
        $merchantUser = $shipment->merchant?->user;
        if ($merchantUser) {
            $recipients->push($merchantUser);
        }

        // إشعار جميع الأدمن
        $admins = User::where('type', UserType::ADMIN)->get();
        $recipients = $recipients->merge($admins);

        if ($recipients->isEmpty()) {
            return;
        }

        Notification::send($recipients, new ShipmentStatusChangedNotification($shipment, $newStatus));
    }

    /**
     * إشعار المستخدم (تاجر أو مندوب) عند إيداع مبلغ في محفظته
     */
    public function notifyWalletDeposit(User $user, float $amount, string $currency = 'QAR', ?string $description = null): void
    {
        $user->notify(new WalletDepositNotification($amount, $currency, $description));
    }
}
