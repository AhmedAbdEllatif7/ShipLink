<?php

namespace App\Http\Controllers\Dashboard\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\ShipmentRequest;
use App\Repositories\Dashboard\Merchant\Shipment\ShipmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Shipment;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

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
        // There is an observer on the shipment model that will handle the notification and status history
        $data = $request->validated();
        $data['merchant_id'] = Auth::user()->merchant->id;

        $this->shipmentRepository->store($data);

        return redirect()->route('merchant.shipments.index')
            ->with('success', 'تم إنشاء الشحنة بنجاح.');
    }

    public function show(Shipment $shipment)
    {
        Gate::authorize('view', $shipment);

        $shipment->load(['statusHistories.user']);

        return view('dashboards.merchant.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        Gate::authorize('update', $shipment);

        return view('dashboards.merchant.shipments.edit', compact('shipment'));
    }

    public function update(ShipmentRequest $request, Shipment $shipment)
    {
        // Authorization is handled. Note: Policy only allows updating PENDING shipments.
        Gate::authorize('update', $shipment);

        $this->shipmentRepository->update($shipment->id, $request->validated());

        return redirect()->route('merchant.shipments.index')->with('success', 'تم تحديث الشحنة بنجاح.');
    }

    public function destroy(Shipment $shipment)
    {
        Gate::authorize('delete', $shipment);

        $this->shipmentRepository->delete($shipment->id);

        return redirect()->route('merchant.shipments.index')->with('success', 'تم حذف الشحنة بنجاح.');
    }
}
