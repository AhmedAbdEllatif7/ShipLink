<?php

namespace App\Repositories\Dashboard\Merchant;

use App\Repositories\Dashboard\DashboardRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class MerchantDashboardRepository implements DashboardRepositoryInterface
{
    public function getOverviewStats(): array
    {
        // Dummy data for now.
        return [
            'wallet_balance' => 4500,
            'pending_shipments' => 12,
            'delivered_shipments' => 84,
            'returned_shipments' => 3,
        ];
    }


}
