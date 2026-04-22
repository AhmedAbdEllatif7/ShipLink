<?php

namespace App\Enums;

enum NotificationType: string
{
    case ShipmentCreated = 'shipment_created';
    case DriverAssigned = 'driver_assigned';
    case ShipmentStatusChanged = 'shipment_status_changed';
    case WalletDeposit = 'wallet_deposit';

    /**
     * الأيقونة المرتبطة بكل نوع إشعار
     */
    public function icon(): string
    {
        return match ($this) {
            self::ShipmentCreated => '📦',
            self::DriverAssigned => '🚚',
            self::ShipmentStatusChanged => '🔄',
            self::WalletDeposit => '💰',
        };
    }

    /**
     * عنوان الإشعار
     */
    public function title(): string
    {
        return match ($this) {
            self::ShipmentCreated => 'شحنة جديدة',
            self::DriverAssigned => 'تكليف بشحنة',
            self::ShipmentStatusChanged => 'تحديث حالة الشحنة',
            self::WalletDeposit => 'إيداع في المحفظة',
        };
    }

    /**
     * لون CSS المرتبط بكل نوع إشعار (Tailwind)
     */
    public function color(): string
    {
        return match ($this) {
            self::ShipmentCreated => 'blue',
            self::DriverAssigned => 'indigo',
            self::ShipmentStatusChanged => 'amber',
            self::WalletDeposit => 'emerald',
        };
    }
}
