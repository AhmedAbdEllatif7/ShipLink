<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\DriverDashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $repository;

    public function __construct(DriverDashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $stats = $this->repository->getOverviewStats();
        $recentActivity = $this->repository->getRecentActivity();

        return view('dashboards.driver.index', compact('stats', 'recentActivity'));
    }
}
