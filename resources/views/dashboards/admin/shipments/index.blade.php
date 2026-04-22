@extends('layouts.admin')

@section('title', 'إدارة الشحنات')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    {{-- Header --}}
    <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div>
            <h3 class="text-xl font-bold text-slate-800">قائمة الشحنات</h3>
            <p class="text-sm text-slate-500 mt-1">عرض وإدارة جميع الشحنات في النظام وتعيين السائقين.</p>
        </div>
    </div>

    {{-- Session Messages --}}
    @if(session('success'))
    <div class="mx-8 mt-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-semibold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/80">
                    <th class="px-8 py-5 text-sm font-bold text-slate-600 border-b border-slate-100">رقم التتبع</th>
                    <th class="px-8 py-5 text-sm font-bold text-slate-600 border-b border-slate-100">التاجر</th>
                    <th class="px-8 py-5 text-sm font-bold text-slate-600 border-b border-slate-100">المستلم/الوجهة</th>
                    <th class="px-8 py-5 text-sm font-bold text-slate-600 border-b border-slate-100">الحالة</th>
                    <th class="px-8 py-5 text-sm font-bold text-slate-600 border-b border-slate-100">السائق</th>
                    <th class="px-8 py-5 text-sm font-bold text-slate-600 border-b border-slate-100 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($shipments as $shipment)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <a href="{{ route('admin.shipments.show', $shipment->id) }}" class="text-sm font-black text-indigo-600 hover:text-indigo-800 hover:underline decoration-2 underline-offset-4 transition-all">
                            {{ $shipment->tracking_number }}
                        </a>
                    </td>                    <td class="px-8 py-5">
                        <div class="text-sm font-bold text-slate-700">{{ $shipment->merchant->user->name }}</div>
                        <div class="text-xs text-slate-400 mt-1">{{ $shipment->merchant->company_name }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="text-sm font-bold text-slate-700">{{ $shipment->receiver_name }}</div>
                        <div class="text-xs text-slate-400 mt-1">{{ $shipment->city }} - {{ $shipment->receiver_address }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-{{ $shipment->status->color() }}-50 text-{{ $shipment->status->color() }}-600 border border-{{ $shipment->status->color() }}-100">
                            {{ $shipment->status->label() }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        @if($shipment->driver)
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center text-[10px] font-bold text-amber-700 uppercase">
                                    {{ substr($shipment->driver->user->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-semibold text-slate-700">{{ $shipment->driver->user->name }}</span>
                            </div>
                        @else
                            <span class="text-xs text-slate-400 italic">غير معين</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-center">
                        {{-- Assign Driver Interaction --}}
                        @if($shipment->status === \App\Enums\ShipmentStatus::PENDING)
                        <form action="{{ route('admin.shipments.assign-driver', $shipment->id) }}" method="POST" class="flex items-center justify-center gap-2">
                            @csrf
                            <select name="driver_id" required class="text-xs border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1 pl-8">
                                <option value="" disabled selected>اختيار سائق...</option>
                                @foreach($drivers as $driverUser)
                                    <option value="{{ $driverUser->driver->id }}">{{ $driverUser->name }} ({{ $driverUser->driver->vehicle_type }})</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-sm">
                                تعيين
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-slate-400">---</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-2.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-slate-500 font-bold">لا توجد شحنات متاحة حالياً.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
