@extends('layouts.driver')

@section('content')
<!-- Driver Summary Header -->
<div class="mb-6 bg-gradient-to-l from-amber-500 to-orange-400 rounded-2xl p-6 shadow-lg shadow-amber-500/20 text-white flex justify-between items-center">
    <div>
        <p class="text-amber-100 text-sm font-medium mb-1">أرباح اليوم المكافئة</p>
        <h2 class="text-3xl font-extrabold">{{ number_format($stats['today_earnings']) }} ج.م</h2>
    </div>
    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
</div>

<h3 class="text-lg font-bold text-slate-800 mb-4 px-1">طريقك اليوم (Routes)</h3>

@can('view assigned shipments')
<div class="grid grid-cols-2 gap-4 mb-6">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 text-center">
        <div class="w-10 h-10 mx-auto rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mb-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800">{{ $stats['pending_deliveries'] }}</h3>
        <p class="text-xs font-semibold text-slate-500 mt-1">بانتظار التوصيل</p>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 text-center">
        <div class="w-10 h-10 mx-auto rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mb-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800">{{ $stats['completed_deliveries'] }}</h3>
        <p class="text-xs font-semibold text-slate-500 mt-1">تمت بنجاح</p>
    </div>
</div>
@endcan

<div class="bg-slate-800 rounded-2xl p-5 text-white flex items-center gap-4 shadow-xl">
    <div class="bg-slate-700 p-3 rounded-xl">
        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
    </div>
    <div class="flex-1">
        <p class="text-xs text-slate-400 mb-1">العهدة المالية المحصلة (Cash)</p>
        <p class="text-lg font-bold">{{ number_format($stats['collected_cash']) }} ج.م</p>
    </div>
    <button class="text-xs font-bold bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-lg transition-colors">
        تسوية
    </button>
</div>

@can('view assigned shipments')
<!-- Active Task (Placeholder) -->
<div class="mt-8 bg-white rounded-2xl p-5 shadow-sm border border-slate-100 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-2 h-full bg-amber-500"></div>
    <h4 class="text-sm font-bold text-slate-800 mb-2">التوصيلة الحالية الأقرب</h4>
    <p class="text-xs text-slate-500">لا توجد شحنات قيد التوصيل في هذه اللحظة، اذهب لخريطة التوصيل لالتقاط شحنات قريبة منك.</p>
    
    <button class="mt-4 w-full bg-amber-50 text-amber-600 font-bold py-3 rounded-xl border border-amber-200">الذهاب لخريطة الشحنات</button>
</div>
@endcan
@endsection
