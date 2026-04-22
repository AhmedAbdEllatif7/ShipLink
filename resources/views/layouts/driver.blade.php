<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تطبيق السائق | ShipLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        /* Hide scrollbar for clean mobile feel */
        ::-webkit-scrollbar { width: 0px; background: transparent; }
    </style>
</head>
<body class="bg-gray-100 text-slate-800 antialiased h-screen flex flex-col md:flex-row overflow-hidden pb-16 md:pb-0">

    <!-- Mobile Header -->
    <header class="h-16 bg-amber-500 flex items-center justify-between px-4 z-20 shadow-md text-white sticky top-0 w-full md:hidden">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <h1 class="text-lg font-bold">كابتن {{ explode(' ', Auth::user()->name)[0] }}</h1>
        </div>
        @include('components.notification-dropdown')
    </header>

    <!-- Desktop Sidebar (Hidden on mobile) -->
    <aside class="w-64 bg-white shadow-xl flex-col hidden md:flex border-l border-slate-100 z-20 h-screen">
        <div class="h-20 flex items-center justify-center border-b border-slate-100 bg-amber-500 text-white">
            <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            <h1 class="text-2xl font-extrabold tracking-tight">Ship<span class="text-white opacity-80">Link</span> للقيادة</h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('driver.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('driver.dashboard') ? 'bg-amber-50 text-amber-700 border border-amber-100' : 'text-slate-500 hover:bg-slate-50 hover:text-amber-600' }} rounded-xl font-bold text-sm transition-colors">
                الرئيسية
            </a>
            @can('view assigned shipments')
            <a href="{{ route('driver.shipments.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('driver.shipments.*') ? 'bg-amber-50 text-amber-700 border border-amber-100 shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-amber-600' }} rounded-xl font-bold text-sm transition-all duration-200">
                شحناتي (المهام)
            </a>
            @endcan
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-500 hover:bg-slate-50 hover:text-amber-600 text-sm">
                المحفظة
            </a>
        </nav>
        
        <div class="p-4 border-t border-slate-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 rounded-xl transition-colors font-semibold">تحديث أو خروج</button>
            </form>
        </div>
    </aside>

    <!-- Main Content (Scrollable Area) -->
    <main class="flex-1 flex flex-col h-full w-full bg-gray-100 overflow-hidden">
        <!-- Desktop Header (Hidden on mobile) -->
        <header class="h-16 bg-white border-b border-slate-100 hidden md:flex items-center justify-between px-8 z-10 shadow-sm">
            <h2 class="text-sm font-bold text-slate-500">لوحة تحكم السائق</h2>
            <div class="flex items-center gap-4">
                @include('components.notification-dropdown')
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Bottom Navigation Bar -->
    <nav class="md:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 z-50 flex justify-around items-center h-16 shadow-[0_-5px_15px_-10px_rgba(0,0,0,0.1)] rounded-t-3xl text-xs font-semibold text-gray-500">
        <!-- Home -->
        <!-- Shipments Task -->
        <a href="{{ route('driver.shipments.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('driver.shipments.*') ? 'text-amber-600' : 'hover:text-amber-600' }} transition-colors">
            <div class="{{ request()->routeIs('driver.shipments.*') ? 'bg-amber-100' : '' }} p-1.5 rounded-full mb-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <span>شحناتي</span>
        </a>

        <!-- Map / Routes -->
        @can('view assigned shipments')
        <a href="#" class="flex flex-col items-center justify-center w-full h-full hover:text-amber-600 transition-colors">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            <span>خريطة الدرب</span>
        </a>
        @endcan

        <!-- Wallet -->
        <a href="#" class="flex flex-col items-center justify-center w-full h-full hover:text-amber-600 transition-colors">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>المُحصّل</span>
        </a>

        <!-- Settings/Logout -->
        <form method="POST" action="{{ route('logout') }}" class="w-full h-full">
            @csrf
            <button type="submit" class="flex flex-col items-center justify-center w-full h-full hover:text-red-500 transition-colors">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>الخروج</span>
            </button>
        </form>
    </nav>

</body>
</html>
