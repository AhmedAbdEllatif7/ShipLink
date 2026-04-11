<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Merchant\MerchantDashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $repository;

    public function __construct(MerchantDashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $stats = $this->repository->getOverviewStats();

        return view('dashboards.merchant.index', compact('stats'));
    }
}
