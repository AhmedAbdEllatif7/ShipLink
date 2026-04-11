<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Admin\AdminDashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $repository;

    public function __construct(AdminDashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $stats = $this->repository->getOverviewStats();

        return view('dashboards.admin.index', compact('stats'));
    }
}
