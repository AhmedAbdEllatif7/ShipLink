<?php

namespace App\Repositories\Dashboard\Driver;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Dashboard\DashboardRepositoryInterface;

class DriverDashboardRepository implements DashboardRepositoryInterface
{
    public function getOverviewStats(): array
    {
        // Dummy data for now.
        return [
            'today_earnings' => 350,
            'pending_deliveries' => 8,
            'completed_deliveries' => 12,
            'collected_cash' => 2400,
        ];
    }

}
