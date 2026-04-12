@extends('layouts.admin')

@section('title', 'لوحة التحكم الرئيسية')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow">
        <div class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-semibold mb-1">إجمالي الإيرادات</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_revenue']) }} ج.م</h3>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow">
        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-semibold mb-1">الشحنات النشطة</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['active_shipments'] }}</h3>
        </div>
    </div>

    @can('view users')
    <!-- Stat Card 3 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow">
        <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-semibold mb-1">التجار (المرسلين)</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_merchants'] }}</h3>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow">
        <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-semibold mb-1">السائقين (المندوبين)</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_drivers'] }}</h3>
        </div>
    </div>
    @endcan

</div>

<!-- Main Area (Charts or Lists) -->
<div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 min-h-[400px] flex items-center justify-center">
    <div class="text-center">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-700">مرحباً بك في مركز الإدارة</h3>
        <p class="text-slate-500 mt-2">جارِ تجهيز الرسوم البيانية التفصيلية...</p>
    </div>
</div>
@endsection
