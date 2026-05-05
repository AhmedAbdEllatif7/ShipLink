<?php

namespace App\Http\Controllers\Dashboard\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateShipmentStatusRequest;
use App\Models\Shipment;
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
    public function updateStatus(UpdateShipmentStatusRequest $request, Shipment $shipment)
    {
        $this->shipmentRepository->updateStatus($shipment, $request->validated('status'), $request->validated('notes'));

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
