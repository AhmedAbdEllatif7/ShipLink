<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Admin\Shipment\ShipmentRepositoryInterface;
use App\Repositories\Dashboard\Admin\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminShipmentController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage all shipments'),
        ];
    }

    public function __construct(
        protected ShipmentRepositoryInterface $shipmentRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Display a listing of all shipments.
     */
    public function index()
    {
        $shipments = $this->shipmentRepository->all();
        $drivers = $this->userRepository->getDrivers();

        return view('dashboards.admin.shipments.index', compact('shipments', 'drivers'));
    }

    /**
     * Assign a driver to a shipment.
     */
    public function assignDriver(Request $request, int $id)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $this->shipmentRepository->assignDriver($id, $request->driver_id);

        return redirect()->back()->with('success', 'تم تعيين السائق بنجاح.');
    }
}
