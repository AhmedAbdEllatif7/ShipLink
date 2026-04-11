<aside class="w-64 bg-emerald-900 text-white shadow-xl flex flex-col hidden lg:flex border-l border-emerald-800 z-20">
    <div class="h-20 flex items-center justify-center border-b border-emerald-800">
        <svg class="w-8 h-8 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        <h1 class="text-2xl font-extrabold tracking-tight text-white">تُجّـار <span class="text-emerald-400">ShipLink</span></h1>
    </div>
    
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="#" class="flex items-center gap-3 px-4 py-3 bg-emerald-700 text-white rounded-xl font-bold text-sm transition-colors shadow-sm">
            <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            الرئيسية
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-emerald-100 hover:bg-emerald-800 hover:text-white transition-colors text-sm">
            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            طلب شحنة جديدة
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-emerald-100 hover:bg-emerald-800 hover:text-white transition-colors text-sm">
            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            شحناتي
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-emerald-100 hover:bg-emerald-800 hover:text-white transition-colors text-sm">
            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            المحفظة والفواتير
        </a>
    </nav>
    
    <div class="p-4 border-t border-emerald-800 bg-emerald-900/50">
        <div class="flex items-center gap-3 px-4 py-3 bg-emerald-800 rounded-xl shadow-sm">
            <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center text-sm font-bold text-white">
                {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'M' }}
            </div>
            <div>
                <p class="text-sm font-bold text-white truncate w-32">{{ Auth::check() ? Auth::user()->name : 'Merchant' }}</p>
                <p class="text-xs text-emerald-300">حساب تاجر</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm text-red-400 hover:bg-emerald-800 hover:text-red-300 rounded-xl transition-colors font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                تسجيل الخروج
            </button>
        </form>
    </div>
</aside>
