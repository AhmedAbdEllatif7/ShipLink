<header class="h-16 bg-amber-500 flex items-center justify-between px-4 z-20 shadow-md text-white sticky top-0 w-full md:hidden">
    <div class="flex items-center gap-2">
        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center font-bold">
            {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'D' }}
        </div>
        <h1 class="text-lg font-bold">كابتن {{ Auth::check() ? explode(' ', Auth::user()->name)[0] : 'Driver' }}</h1>
    </div>
    <button class="w-10 h-10 flex items-center justify-center relative">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        <span class="absolute top-2 right-2 w-2 h-2 bg-red-600 rounded-full border border-white"></span>
    </button>
</header>
