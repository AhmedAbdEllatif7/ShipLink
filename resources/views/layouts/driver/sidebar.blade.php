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
