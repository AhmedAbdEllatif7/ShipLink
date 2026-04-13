<?php

namespace App\Http\Controllers\Dashboard\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\ShipmentRequest;
use App\Repositories\Dashboard\Merchant\Shipment\ShipmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipment;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MerchantShipmentController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view own shipments', only: ['index', 'show']),
            new Middleware('permission:create shipments', only: ['create', 'store']),
            new Middleware('permission:edit own shipments', only: ['edit', 'update']),
            new Middleware('permission:delete own shipments', only: ['destroy']),
        ];
    }
    protected $shipmentRepository;

    public function __construct(ShipmentRepositoryInterface $shipmentRepository)
    {
        $this->shipmentRepository = $shipmentRepository;
    }

    public function index()
    {
        $shipments = $this->shipmentRepository->getMerchantShipments(Auth::user()->merchant);
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

    public function show(Shipment $shipment)
    {
        // Security check
        if ($shipment->merchant_id !== Auth::user()->merchant->id) {
            abort(403);
        }

        return view('dashboards.merchant.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        if ($shipment->merchant_id !== Auth::user()->merchant->id || $shipment->status->value !== \App\Enums\ShipmentStatus::PENDING->value) {
            return redirect()->route('merchant.shipments.index')->with('error', 'لا يمكن تعديل هذه الشحنة.');
        }

        return view('dashboards.merchant.shipments.edit', compact('shipment'));
    }

    public function update(ShipmentRequest $request, Shipment $shipment)
    {
        if ($shipment->merchant_id !== Auth::user()->merchant->id || $shipment->status->value !== \App\Enums\ShipmentStatus::PENDING->value) {
            return redirect()->route('merchant.shipments.index')->with('error', 'لا يمكن تعديل هذه الشحنة.');
        }

        $this->shipmentRepository->update($shipment->id, $request->validated());

        return redirect()->route('merchant.shipments.index')->with('success', 'تم تحديث الشحنة بنجاح.');
    }

    public function destroy(Shipment $shipment)
    {
        if ($shipment->merchant_id !== Auth::user()->merchant->id || $shipment->status->value !== \App\Enums\ShipmentStatus::PENDING->value) {
            return redirect()->route('merchant.shipments.index')->with('error', 'لا يمكن حذف هذه الشحنة.');
        }

        $this->shipmentRepository->delete($shipment->id);

        return redirect()->route('merchant.shipments.index')->with('success', 'تم حذف الشحنة بنجاح.');
    }
}
