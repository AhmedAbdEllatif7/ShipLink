<?php

namespace App\Repositories\Dashboard\Admin;
use App\Repositories\Dashboard\DashboardRepositoryInterface;

class AdminDashboardRepository implements DashboardRepositoryInterface
{
    public function getOverviewStats(): array
    {
        // Dummy data for now. We will replace this with real DB queries.
        return [
            'total_revenue' => 125000,
            'active_shipments' => 342,
            'total_drivers' => 45,
            'total_merchants' => 120,
        ];
    }


}
