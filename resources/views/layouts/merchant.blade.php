<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التاجر | ShipLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-emerald-50 text-slate-800 antialiased h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-xl flex flex-col hidden lg:flex border-l border-slate-100 z-20">
        <div class="h-20 flex items-center justify-center border-b border-slate-100">
            <svg class="w-8 h-8 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">تُجّـار <span class="text-emerald-600">ShipLink</span></h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold text-sm transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                الرئيسية
            </a>
            @can('create shipments')
            <a href="{{ route('merchant.shipments.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-500 hover:bg-slate-50 hover:text-emerald-600 transition-colors text-sm {{ request()->routeIs('merchant.shipments.create') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                طلب شحنة جديدة
            </a>
            @endcan

            @can('view own shipments')
            <a href="{{ route('merchant.shipments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-500 hover:bg-slate-50 hover:text-emerald-600 transition-colors text-sm {{ request()->routeIs('merchant.shipments.*') && !request()->routeIs('merchant.shipments.create') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                شحناتي
            </a>
            @endcan
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-500 hover:bg-slate-50 hover:text-emerald-600 transition-colors text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                المحفظة والفواتير
            </a>
        </nav>
        
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3 px-4 py-3 bg-white border border-slate-100 rounded-xl shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-sm font-bold text-emerald-700">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-700 truncate w-32">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500">حساب تاجر</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 rounded-xl transition-colors font-semibold">
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-emerald-100/50 flex items-center justify-between px-8 z-10 shadow-sm">
            <h2 class="text-xl font-bold text-slate-800">@yield('title', 'نبذة عامة')</h2>
            
            <div class="flex items-center gap-4">
                <button class="relative w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </button>
            </div>
        </header>

        <!-- Dynamic Page Content -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-[#f8fafc] bg-[url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%2310b981\' fill-opacity=\'0.03\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E')]">
            @yield('content')
        </div>
    </main>

</body>
</html>
