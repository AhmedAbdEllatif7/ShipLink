<?php

namespace App\Http\Controllers\Dashboard\Driver;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Driver\Shipment\ShipmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverShipmentController extends Controller
{
    public function __construct(
        protected ShipmentRepositoryInterface $shipmentRepository
    ) {}

    /**
     * Display a listing of shipments assigned to the driver.
     */
    public function index()
    {
        $driver = Auth::user()->driver;
        $shipments = $this->shipmentRepository->getDriverShipments($driver);

        return view('dashboards.driver.shipments.index', compact('shipments'));
    }

    /**
     * Update the status of a specific shipment.
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string|max:255',
        ]);

        $this->shipmentRepository->updateStatus($id, $request->status, $request->notes);

        return redirect()->back()->with('success', 'تم تحديث حالة الشحنة بنجاح.');
    }

    /**
     * Display the specified shipment details for the driver.
     */
    public function show(int $id)
    {
        $shipment = $this->shipmentRepository->find($id);

        return view('dashboards.driver.shipments.show', compact('shipment'));
    }
}
