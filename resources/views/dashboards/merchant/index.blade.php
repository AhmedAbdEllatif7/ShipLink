@extends('layouts.merchant')

@section('title', 'ملخص الحساب')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100/50 flex items-center gap-5 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-l from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="z-10">
            <p class="text-slate-500 text-sm font-semibold mb-1">رصيد المحفظة</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ number_format($stats['wallet_balance']) }} ج.م</h3>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100/50 flex items-center gap-5 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-l from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="z-10">
            <p class="text-slate-500 text-sm font-semibold mb-1">شحنات قيد التوصيل</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['pending_shipments'] }}</h3>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100/50 flex items-center gap-5 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-l from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="w-14 h-14 rounded-xl bg-green-50 text-green-600 flex items-center justify-center border border-green-100">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div class="z-10">
            <p class="text-slate-500 text-sm font-semibold mb-1">شحنات مكتملة</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['delivered_shipments'] }}</h3>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100/50 flex items-center gap-5 relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-l from-red-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="w-14 h-14 rounded-xl bg-red-50 text-red-600 flex items-center justify-center border border-red-100">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="z-10">
            <p class="text-slate-500 text-sm font-semibold mb-1">مرتجعات</p>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['returned_shipments'] }}</h3>
        </div>
    </div>

</div>

<!-- Call to action area -->
<div class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-3xl p-8 shadow-lg shadow-emerald-600/20 text-white flex flex-col md:flex-row items-center justify-between">
    <div>
        <h3 class="text-2xl font-bold mb-2">أضف شحنتك الأولى اليوم!</h3>
        <p class="text-emerald-100">نظام ذكي يوصل شحنتك لعميلك في أسرع وقت مع متابعة حية.</p>
    </div>
    <a href="{{ route('merchant.shipments.create') }}" class="mt-4 md:mt-0 bg-white text-emerald-600 font-bold py-3 px-8 rounded-xl hover:shadow-xl hover:-translate-y-1 transition-all">
        + إنشاء شحنة جديدة
    </a>
</div>
@endsection
