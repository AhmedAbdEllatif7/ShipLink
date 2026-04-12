<?php

namespace App\Http\Controllers\Dashboard\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\ShipmentRequest;
use App\Repositories\Dashboard\Shipment\ShipmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class MerchantShipmentController extends Controller
{
    protected $shipmentRepository;

    public function __construct(ShipmentRepositoryInterface $shipmentRepository)
    {
        $this->shipmentRepository = $shipmentRepository;
    }

    public function index()
    {
        $shipments = $this->shipmentRepository->getMerchantShipments(Auth::user()->merchant->id);
        return view('dashboards.merchant.shipments.index', compact('shipments'));
    }

    public function create()
    {
        return view('dashboards.merchant.shipments.create');
    }

    public function store(ShipmentRequest $request)
    {
        $data = $request->validated();
        $data['merchant_id'] = Auth::user()->merchant->id;

        $this->shipmentRepository->store($data);

        return redirect()->route('merchant.shipments.index')
            ->with('success', 'تم إنشاء الشحنة بنجاح.');
    }

    public function show($id)
    {
        $shipment = $this->shipmentRepository->find($id);
        
        // Security check
        if ($shipment->merchant_id !== Auth::user()->merchant->id) {
            abort(403);
        }

        return view('dashboards.merchant.shipments.show', compact('shipment'));
    }

    public function edit($id)
    {
        $shipment = $this->shipmentRepository->find($id);

        if ($shipment->merchant_id !== Auth::user()->merchant->id || $shipment->status->value !== \App\Enums\ShipmentStatus::PENDING->value) {
            return redirect()->route('merchant.shipments.index')->with('error', 'لا يمكن تعديل هذه الشحنة.');
        }

        return view('dashboards.merchant.shipments.edit', compact('shipment'));
    }

    public function update(ShipmentRequest $request, $id)
    {
        $shipment = $this->shipmentRepository->find($id);

        if ($shipment->merchant_id !== Auth::user()->merchant->id || $shipment->status->value !== \App\Enums\ShipmentStatus::PENDING->value) {
            return redirect()->route('merchant.shipments.index')->with('error', 'لا يمكن تعديل هذه الشحنة.');
        }

        $this->shipmentRepository->update($id, $request->validated());

        return redirect()->route('merchant.shipments.index')->with('success', 'تم تحديث الشحنة بنجاح.');
    }

    public function destroy($id)
    {
        $shipment = $this->shipmentRepository->find($id);

        if ($shipment->merchant_id !== Auth::user()->merchant->id || $shipment->status->value !== \App\Enums\ShipmentStatus::PENDING->value) {
            return redirect()->route('merchant.shipments.index')->with('error', 'لا يمكن حذف هذه الشحنة.');
        }

        $this->shipmentRepository->delete($id);

        return redirect()->route('merchant.shipments.index')->with('success', 'تم حذف الشحنة بنجاح.');
    }
}
