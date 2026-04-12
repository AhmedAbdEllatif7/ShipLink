<?php

namespace App\Http\Controllers\Dashboard\Driver;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Driver\DriverDashboardRepository;
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

        return view('dashboards.driver.index', compact('stats'));
    }
}
