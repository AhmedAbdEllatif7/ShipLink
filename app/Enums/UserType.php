<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case MERCHANT = 'merchant';
    case DRIVER = 'driver';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::MERCHANT => 'Merchant',
            self::DRIVER => 'Driver',
        };
    }
}
