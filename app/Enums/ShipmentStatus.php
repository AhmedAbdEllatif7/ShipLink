<?php

namespace App\Enums;

enum ShipmentStatus: string
{
    case PENDING = 'pending';
    case ASSIGNED = 'assigned';
    case PICKED_UP = 'picked_up';
    case IN_TRANSIT = 'in_transit';
    case OUT_FOR_DELIVERY = 'out_for_delivery';
    case DELIVERED = 'delivered';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
    case RETURNED = 'returned';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'قيد الانتظار',
            self::ASSIGNED => 'تم التعيين',
            self::PICKED_UP => 'تم الاستلام',
            self::IN_TRANSIT => 'في الطريق',
            self::OUT_FOR_DELIVERY => 'خارج للتوصيل',
            self::DELIVERED => 'تم التسليم',
            self::FAILED => 'فشل التسليم',
            self::CANCELLED => 'ملغى',
            self::RETURNED => 'مرتجع',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::ASSIGNED => 'blue',
            self::PICKED_UP => 'indigo',
            self::IN_TRANSIT => 'yellow',
            self::OUT_FOR_DELIVERY => 'amber',
            self::DELIVERED => 'green',
            self::FAILED => 'red',
            self::CANCELLED => 'rose',
            self::RETURNED => 'orange',
        };
    }
}
