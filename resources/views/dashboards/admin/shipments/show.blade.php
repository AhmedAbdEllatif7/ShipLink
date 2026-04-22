@extends('layouts.admin')

@section('title', 'تفاصيل الشحنة #' . $shipment->tracking_number)

@section('content')
<div class="space-y-8">
    {{-- Top Action Bar --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.shipments.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-colors font-bold text-sm bg-white px-4 py-2 rounded-xl border border-slate-100 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            العودة للقائمة
        </a>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider bg-{{ $shipment->status->color() }}-50 text-{{ $shipment->status->color() }}-600 border border-{{ $shipment->status->color() }}-100 shadow-sm">
                {{ $shipment->status->label() }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Details --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Shipment Information Card --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50/50 rounded-full -mr-12 -mt-12"></div>
                
                <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-3">
                    <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                    بيانات الشحنة الأساسية
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">رقم التتبع العالمي</p>
                        <p class="text-lg font-black text-indigo-600 tracking-tight">{{ $shipment->tracking_number }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">المسؤول عن التوصيل</p>
                        @if($shipment->driver)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-xs font-bold text-amber-700">
                                    {{ substr($shipment->driver->user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-700">{{ $shipment->driver->user->name }}</span>
                            </div>
                        @else
                            <span class="text-sm font-bold text-slate-400 italic">غير معين لأي سائق</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">اسم المستلم</p>
                        <p class="text-md font-bold text-slate-700">{{ $shipment->receiver_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">رقم الهاتف</p>
                        <p class="text-md font-bold text-slate-700" dir="ltr">{{ $shipment->receiver_phone }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">عنوان التوصيل</p>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 italic text-slate-600 text-sm">
                            {{ $shipment->city }} - {{ $shipment->receiver_address }}
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">المبلغ المطلوب تحصيله (COD)</p>
                        <p class="text-2xl font-black text-emerald-600">{{ number_format($shipment->cod_amount) }} <span class="text-xs">ج.م</span></p>
                    </div>
                </div>
            </div>

            {{-- Participants Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Merchant Info --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-4">التاجر (المرسل)</p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-xl">
                            🏢
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800">{{ $shipment->merchant->company_name }}</h4>
                            <p class="text-xs text-slate-500 font-bold mt-1 text-indigo-600">{{ $shipment->merchant->user->name }}</p>
                        </div>
                    </div>
                </div>

                {{-- Driver Info --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-4">السائق (المكلف)</p>
                    @if($shipment->driver)
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-xl">
                            🚚
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800">{{ $shipment->driver->user->name }}</h4>
                            <p class="text-xs text-slate-500 font-bold mt-1 text-amber-600">{{ $shipment->driver->vehicle_type }}</p>
                        </div>
                    </div>
                    @else
                    <div class="py-2 text-center text-slate-400 text-sm font-bold italic">لا يوجد سائق مكلف حالياً</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Timeline --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 h-full">
                <h3 class="text-lg font-black text-slate-800 mb-8 flex items-center gap-3">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    سجل التحركات (History)
                </h3>

                <div class="relative">
                    {{-- Vertical Line --}}
                    <div class="absolute right-3.5 top-0 bottom-0 w-0.5 bg-slate-100"></div>

                    <div class="space-y-8 relative">
                        @foreach($shipment->statusHistories->sortByDesc('id') as $history)
                        <div class="relative pr-10">
                            {{-- Dot --}}
                            <div class="absolute right-0 top-1 w-7 h-7 rounded-full bg-white border-4 border-{{ $history->status->color() }}-500 z-10 flex items-center justify-center">
                                <div class="w-1.5 h-1.5 rounded-full bg-{{ $history->status->color() }}-500 animate-pulse"></div>
                            </div>
                            
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-black uppercase text-{{ $history->status->color() }}-600 bg-{{ $history->status->color() }}-100 px-2 py-0.5 rounded-md">
                                        {{ $history->status->label() }}
                                    </span>
                                    <span class="text-[9px] font-bold text-slate-400">
                                        {{ $history->created_at->format('Y/m/d H:i') }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-700 font-semibold leading-relaxed">{{ $history->notes ?? 'تم تحديث الحالة بنجاح.' }}</p>
                                <div class="mt-3 flex items-center gap-1.5 text-[9px] font-bold text-slate-400">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    بواسطة: {{ $history->user?->name ?? 'النظام الآلي' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
