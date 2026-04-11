<aside class="w-64 bg-slate-900 text-white shadow-xl flex-col hidden md:flex border-l border-slate-800 z-20 h-screen">
    <div class="h-20 flex items-center justify-center border-b border-slate-800 bg-amber-500 text-white">
        <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
        <h1 class="text-2xl font-extrabold tracking-tight">Ship<span class="text-white opacity-80">Link</span> للقيادة</h1>
    </div>
    
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="#" class="flex items-center gap-3 px-4 py-3 bg-amber-500 text-white rounded-xl font-bold text-sm shadow-md">
            الرئيسية
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-300 hover:bg-slate-800 hover:text-amber-400 transition-colors text-sm">
            خريطة التوصيل
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-slate-300 hover:bg-slate-800 hover:text-amber-400 transition-colors text-sm">
            المحفظة
        </a>
    </nav>
    
    <div class="p-4 border-t border-slate-800">
        <div class="flex items-center gap-3 px-4 py-3 bg-slate-800 rounded-xl mb-2">
            <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-sm font-bold text-white">
                {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'D' }}
            </div>
            <div>
                <p class="text-sm font-bold text-white">{{ Auth::check() ? Auth::user()->name : 'Driver' }}</p>
                <p class="text-xs text-slate-400">كابتن توصيل</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm text-red-400 hover:bg-slate-800 hover:text-red-300 rounded-xl transition-colors font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                خروج
            </button>
        </form>
    </div>
</aside>
