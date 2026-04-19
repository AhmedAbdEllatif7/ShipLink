@extends('layouts.merchant')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h2 class="text-2xl font-semibold text-slate-800">تفاصيل الشحنة: {{ $shipment->tracking_number }}</h2>
                    <div class="flex gap-2">
                        @can('update', $shipment)
                            <a href="{{ route('merchant.shipments.edit', $shipment->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition duration-200 text-sm">
                                تعديل الشحنة
                            </a>
                        @endcan
                        <a href="{{ route('merchant.shipments.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-2 px-4 rounded transition duration-200 text-sm">
                            العودة للقائمة
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Basic Info -->
                    <div>
                        <h3 class="text-lg font-bold text-emerald-700 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            بيانات المستلم
                        </h3>
                        <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <p><span class="text-slate-500 text-sm block">الاسم:</span> <span class="font-semibold">{{ $shipment->receiver_name }}</span></p>
                            <p><span class="text-slate-500 text-sm block">رقم الهاتف:</span> <span class="font-semibold">{{ $shipment->receiver_phone }}</span></p>
                            <p><span class="text-slate-500 text-sm block">المدينة:</span> <span class="font-semibold">{{ $shipment->city }}</span></p>
                            <p><span class="text-slate-500 text-sm block">العنوان:</span> <span class="font-semibold">{{ $shipment->receiver_address }}</span></p>
                        </div>
                    </div>

                    <!-- Logistics Info -->
                    <div>
                        <h3 class="text-lg font-bold text-emerald-700 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                            بيانات الشحنة
                        </h3>
                        <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <p><span class="text-slate-500 text-sm block">مبلغ التحصيل (COD):</span> <span class="font-bold text-lg text-emerald-600">{{ number_format($shipment->cod_amount, 2) }} ج.م</span></p>
                            <p>
                                <span class="text-slate-500 text-sm block">حالة الشحنة:</span> 
                                <span class="inline-block px-3 py-1 font-semibold text-{{ $shipment->status->color() }}-900 bg-{{ $shipment->status->color() }}-100 rounded-full text-sm">
                                    {{ $shipment->status->label() }}
                                </span>
                            </p>
                            @if($shipment->driver)
                                <p><span class="text-slate-500 text-sm block">السائق المسؤول:</span> <span class="font-semibold">{{ $shipment->driver->user->name }}</span></p>
                            @endif
                            <p><span class="text-slate-500 text-sm block">تاريخ الإنشاء:</span> <span class="font-semibold">{{ $shipment->created_at->format('Y-m-d H:i') }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Status History -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-emerald-700 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        سجل التتبع
                    </h3>
                    <div class="relative">
                        <div class="absolute right-4 top-0 bottom-0 w-0.5 bg-slate-200"></div>
                        <div class="space-y-6">
                            @foreach($shipment->statusHistories as $history)
                                <div class="relative pr-10">
                                    <div class="absolute right-[13px] top-1.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white"></div>
                                    <div class="bg-white p-3 rounded-lg border border-slate-100 shadow-sm ml-4">
                                        <p class="font-bold text-sm text-slate-800">{{ \App\Enums\ShipmentStatus::from($history->status)->label() }}</p>
                                        <p class="text-xs text-slate-500">{{ $history->created_at->format('Y-m-d H:i') }}</p>
                                        @if($history->notes)
                                            <p class="mt-2 text-sm text-slate-600 bg-slate-50 p-2 rounded border-r-2 border-emerald-300">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
