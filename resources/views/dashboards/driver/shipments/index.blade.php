@extends('layouts.driver')

@section('content')
<div class="space-y-6 pb-20">
    {{-- Page Header --}}
    <div class="px-1">
        <h2 class="text-2xl font-extrabold text-slate-800">شحناتي المكلف بها</h2>
        <p class="text-sm text-slate-500 mt-1">إدارة الشحنات وتحديث حالات التوصيل لحظياً.</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded-2xl flex items-center gap-3 animate-pulse">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-xs font-bold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Shipments List --}}
    <div class="space-y-4">
        @forelse($shipments as $shipment)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative group transition-all hover:shadow-md">
            {{-- Status Strip --}}
            <div class="absolute top-0 right-0 w-1.5 h-full bg-{{ $shipment->status->color() }}-500"></div>

            <div class="p-5">
                {{-- Top Info --}}
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">رقم التتبع</span>
                        <h4 class="text-lg font-black text-indigo-600">{{ $shipment->tracking_number }}</h4>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-{{ $shipment->status->color() }}-50 text-{{ $shipment->status->color() }}-600 border border-{{ $shipment->status->color() }}-100">
                        {{ $shipment->status->label() }}
                    </span>
                </div>

                {{-- Receiver Info --}}
                <div class="space-y-3 bg-slate-50 rounded-xl p-4 mb-5 border border-slate-100">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-700">{{ $shipment->receiver_name }}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $shipment->receiver_phone }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-700">{{ $shipment->city }}</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $shipment->receiver_address }}</p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="grid grid-cols-2 gap-3">
                    @if($shipment->status === \App\Enums\ShipmentStatus::ASSIGNED)
                    <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST" class="col-span-2">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::PICKED_UP->value }}">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-95">
                            تأكيد الاستلام من التاجر
                        </button>
                    </form>
                    @elseif($shipment->status === \App\Enums\ShipmentStatus::PICKED_UP || $shipment->status === \App\Enums\ShipmentStatus::IN_TRANSIT)
                        @if($shipment->status === \App\Enums\ShipmentStatus::PICKED_UP)
                        <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::IN_TRANSIT->value }}">
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold py-3 rounded-xl active:scale-95">
                                الخروج للتوصيل (في الطريق)
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST" class="{{ $shipment->status === \App\Enums\ShipmentStatus::IN_TRANSIT ? 'col-span-2' : '' }}">
                            @csrf
                            <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::OUT_FOR_DELIVERY->value }}">
                            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold py-3 rounded-xl active:scale-95">
                                وصلت وجهة العميل (بانتظار التسليم)
                            </button>
                        </form>
                    @elseif($shipment->status === \App\Enums\ShipmentStatus::OUT_FOR_DELIVERY)
                    <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::DELIVERED->value }}">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-3 rounded-xl transition-all active:scale-95">
                            تم التوصيل بنجاح ✅
                        </button>
                    </form>
                    <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::CANCELLED->value }}">
                        <button type="submit" class="w-full bg-red-50 text-red-500 border border-red-100 text-xs font-bold py-3 rounded-xl active:scale-95">
                            فشل / مرتجع ❌
                        </button>
                    </form>
                    @else
                        <div class="col-span-2 text-center py-2 bg-slate-100 rounded-xl border border-dashed border-slate-200">
                            <span class="text-xs text-slate-400 font-bold italic tracking-wide">لا توجد إجراءات متاحة لهذه الحالة</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center bg-white rounded-3xl border border-slate-100 shadow-sm px-6">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h3 class="text-slate-800 font-bold mb-2">قائمة المهمات فارغة</h3>
            <p class="text-xs text-slate-500 leading-relaxed">لم يتم تكليفك بأي شحنات بعد، أو تم شحن جميع ملفاتك بنجاح.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
