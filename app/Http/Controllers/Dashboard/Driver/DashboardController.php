<?php

namespace App\Http\Controllers\Dashboard\Driver;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Driver\DriverDashboardRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view assigned shipments', only: ['index']),
        ];
    }
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
