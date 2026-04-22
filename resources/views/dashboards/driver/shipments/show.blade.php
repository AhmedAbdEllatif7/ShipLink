@extends('layouts.driver')

@section('content')
<div class="space-y-6 pb-20">
    {{-- Header --}}
    <div class="flex items-center justify-between px-1">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">تفاصيل المهمة</h2>
            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">شحنة رقم #{{ $shipment->tracking_number }}</p>
        </div>
        <a href="{{ route('driver.shipments.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100 text-slate-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </a>
    </div>

    {{-- Main Status Card --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-2 h-full bg-{{ $shipment->status->color() }}-500"></div>
        
        <div class="flex justify-between items-center mb-6">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-{{ $shipment->status->color() }}-50 text-{{ $shipment->status->color() }}-600 border border-{{ $shipment->status->color() }}-100 whitespace-nowrap">
                {{ $shipment->status->label() }}
            </span>
            <span class="text-[10px] font-bold text-slate-400 capitalize">{{ $shipment->updated_at->diffForHumans() }}</span>
        </div>

        <div class="space-y-6">
            {{-- Receiver --}}
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-slate-50 flex items-center justify-center text-lg shadow-inner">👤</div>
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">المستلم</p>
                    <p class="text-sm font-black text-slate-800">{{ $shipment->receiver_name }}</p>
                    <p class="text-xs text-indigo-600 font-bold" dir="ltr">{{ $shipment->receiver_phone }}</p>
                </div>
            </div>

            {{-- Address --}}
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-lg shadow-inner">📍</div>
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">العنوان</p>
                    <p class="text-sm font-black text-slate-800">{{ $shipment->city }}</p>
                    <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed">{{ $shipment->receiver_address }}</p>
                </div>
            </div>

            {{-- Amount --}}
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-lg shadow-inner">💰</div>
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">المبلغ المطلوب (COD)</p>
                    <p class="text-lg font-black text-emerald-600">{{ number_format($shipment->cod_amount) }} <span class="text-[10px] text-emerald-500">ج.م</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions Bar --}}
    <div class="bg-white rounded-3xl p-5 shadow-lg border border-slate-100">
        <h3 class="text-xs font-black text-slate-800 mb-4 px-1">تحديث حالة المهمة</h3>
        <div class="grid grid-cols-1 gap-3">
            @if($shipment->status === \App\Enums\ShipmentStatus::ASSIGNED)
            <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::PICKED_UP->value }}">
                <button type="submit" class="w-full bg-indigo-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-100 flex items-center justify-center gap-2 active:scale-95 transition-all">
                    <span>تأكيد الاستلام من التاجر</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            @elseif($shipment->status === \App\Enums\ShipmentStatus::PICKED_UP || $shipment->status === \App\Enums\ShipmentStatus::IN_TRANSIT)
                <div class="grid grid-cols-2 gap-3">
                    @if($shipment->status === \App\Enums\ShipmentStatus::PICKED_UP)
                    <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::IN_TRANSIT->value }}">
                        <button type="submit" class="w-full bg-blue-500 text-white text-[11px] font-black py-4 rounded-2xl active:scale-95 transition-all">
                            الخروج للتوصيل
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST" class="{{ $shipment->status === \App\Enums\ShipmentStatus::IN_TRANSIT ? 'col-span-2' : '' }}">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::OUT_FOR_DELIVERY->value }}">
                        <button type="submit" class="w-full bg-amber-500 text-white text-[11px] font-black py-4 rounded-2xl active:scale-95 transition-all">
                            وصلت وجهة العميل
                        </button>
                    </form>
                </div>
            @elseif($shipment->status === \App\Enums\ShipmentStatus::OUT_FOR_DELIVERY)
                <div class="grid grid-cols-1 gap-3">
                    <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::DELIVERED->value }}">
                        <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-100 active:scale-95 transition-all">
                            تم التوصيل بنجاح ✅
                        </button>
                    </form>
                    <form action="{{ route('driver.shipments.update-status', $shipment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ \App\Enums\ShipmentStatus::CANCELLED->value }}">
                        <button type="submit" class="w-full bg-red-50 text-red-500 border border-red-100 text-xs font-bold py-3 rounded-2xl active:scale-95 transition-all">
                            فشل التوصيل / مرتجع ❌
                        </button>
                    </form>
                </div>
            @else
                <div class="text-center py-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <span class="text-xs text-slate-400 font-bold">تم إنهاء هذه المهمة بنجاح</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Timeline --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
        <h3 class="text-xs font-black text-slate-800 mb-6 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            تتبع التحركات
        </h3>
        
        <div class="space-y-6 relative before:absolute before:right-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-50">
            @foreach($shipment->statusHistories->sortByDesc('id') as $history)
            <div class="relative pr-8">
                <div class="absolute right-0 top-1 w-4 h-4 rounded-full bg-white border-2 border-{{ $history->status->color() }}-500 z-10"></div>
                <div class="flex justify-between items-start mb-1">
                    <span class="text-[10px] font-black text-{{ $history->status->color() }}-600">{{ $history->status->label() }}</span>
                    <span class="text-[9px] font-bold text-slate-400">{{ $history->created_at->format('H:i') }}</span>
                </div>
                <p class="text-[11px] text-slate-500 font-medium">{{ $history->notes ?? 'تحديث تلقائي للنظام' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
