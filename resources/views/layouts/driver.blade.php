<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <button class="w-10 h-10 flex items-center justify-center relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-600 rounded-full border border-white"></span>
        </button>
    </header>

    <!-- Desktop Sidebar (Hidden on mobile) -->
    <aside class="w-64 bg-white shadow-xl flex-col hidden md:flex border-l border-slate-100 z-20 h-screen">
        <div class="h-20 flex items-center justify-center border-b border-slate-100 bg-amber-500 text-white">
            <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            <h1 class="text-2xl font-extrabold tracking-tight">Ship<span class="text-white opacity-80">Link</span> للقيادة</h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-amber-50 text-amber-700 border border-amber-100 rounded-xl font-bold text-sm">
                الرئيسية
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-500 hover:bg-slate-50 hover:text-amber-600 text-sm">
                خريطة التوصيل
            </a>
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
    <main class="flex-1 overflow-y-auto h-full w-full bg-gray-100 p-4 md:p-8">
        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation Bar -->
    <nav class="md:hidden fixed bottom-0 w-full bg-white border-t border-gray-200 z-50 flex justify-around items-center h-16 shadow-[0_-5px_15px_-10px_rgba(0,0,0,0.1)] rounded-t-3xl text-xs font-semibold text-gray-500">
        <!-- Home -->
        <a href="#" class="flex flex-col items-center justify-center w-full h-full text-amber-600">
            <div class="bg-amber-100 p-1.5 rounded-full mb-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <span>الرئيسية</span>
        </a>

        <!-- Map / Routes -->
        <a href="#" class="flex flex-col items-center justify-center w-full h-full hover:text-amber-600 transition-colors">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            <span>خريطة الدرب</span>
        </a>

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
