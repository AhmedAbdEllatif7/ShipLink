<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ShipLink') }} - المنصة الأسرع للشحن</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .glass-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-indigo-600 selection:text-white">

    <!-- Navbar -->
    <nav class="absolute top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-indigo-200">
                        S
                    </div>
                    <span class="font-black text-2xl text-slate-800 tracking-tight">Ship<span class="text-indigo-600">Link</span></span>
                </div>
                
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                            الذهاب للوحة التحكم &larr;
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors hidden sm:block">تسجيل الدخول</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-indigo-200 active:scale-95">
                                انضم كتاجر
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow flex flex-col items-center pt-32 pb-16 relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        <div class="absolute top-0 left-0 -ml-20 -mt-20 w-72 h-72 bg-amber-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>

        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10 text-center mt-12">
            <span class="inline-block py-1.5 px-4 rounded-full bg-indigo-50 text-indigo-600 text-xs font-black tracking-wide mb-6 border border-indigo-100">النظام الأذكى لإدارة عمليات الشحن</span>
            
            <h1 class="text-5xl md:text-7xl font-black text-slate-900 mb-6 leading-tight">
                شحنتك بين إيديك،<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-indigo-400">لحظة بلحظة.</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-500 mb-12 max-w-2xl mx-auto font-medium">
                تتبع مسار شحنتك بكل سهولة وشفافية. أدخل رقم التتبع الخاص بك لمعرفة أحدث مستجدات التوصيل.
            </p>

            <!-- Tracking Form -->
            <div class="max-w-2xl mx-auto relative mb-20">
                <form action="{{ route('home.track') }}" method="POST" class="relative group">
                    @csrf
                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-indigo-400 group-focus-within:text-indigo-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="tracking_number" value="{{ old('tracking_number') }}" required
                           class="block w-full pl-36 pr-16 py-6 border-2 border-transparent bg-white rounded-2xl text-lg font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0 focus:border-indigo-500 shadow-xl shadow-slate-200/50 transition-all"
                           placeholder="مثال: SHP-123456789">
                    
                    <div class="absolute inset-y-2 left-2 flex items-center">
                        <button type="submit" class="h-full bg-indigo-600 hover:bg-indigo-700 text-white font-black px-8 rounded-xl transition-all shadow-md active:scale-95 flex items-center gap-2">
                            <span>تتبع الآن</span>
                            <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
                @error('tracking_number')
                    <p class="text-red-500 text-sm font-bold mt-3 text-right">{{ $message }}</p>
                @enderror
                @if(session('error'))
                    <div class="mt-4 p-4 bg-red-50 border border-red-100 rounded-xl text-red-600 text-sm font-bold flex items-center gap-3 animate-pulse">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Tracking Result Area -->
            @if(session('shipment'))
                @php 
                    $shipment = session('shipment'); 
                    $statusColor = $shipment->status->color();
                    $statusLabel = $shipment->status->label();
                @endphp
                <div id="tracking-result" class="max-w-3xl mx-auto glass-panel rounded-3xl p-8 border border-slate-100 shadow-2xl shadow-slate-200/50 text-right animate-[fadeIn_0.5s_ease-out]">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-slate-100 pb-6 mb-6 gap-4">
                        <div>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">رقم الشحنة</p>
                            <h2 class="text-2xl font-black text-slate-800 font-mono">{{ $shipment->tracking_number }}</h2>
                        </div>
                        <div class="text-left">
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-black border" 
                                  style="color: {{ $statusColor }}; background-color: {{ $statusColor }}10; border-color: {{ $statusColor }}30;">
                                <span class="w-2 h-2 rounded-full animate-pulse" style="background-color: {{ $statusColor }};"></span>
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                            <div class="flex items-center gap-3 mb-2 text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-xs font-black text-slate-500 uppercase">وجهة التسليم</span>
                            </div>
                            <p class="text-lg font-bold text-slate-800">{{ $shipment->city }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                            <div class="flex items-center gap-3 mb-2 text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs font-black text-slate-500 uppercase">تاريخ التحديث</span>
                            </div>
                            <p class="text-lg font-bold text-slate-800" dir="ltr">{{ $shipment->updated_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>

                    @if($shipment->statusHistories->count() > 0)
                        <h3 class="text-lg font-black text-slate-800 mb-6">سجل مسار الشحنة</h3>
                        <div class="relative border-r-2 border-slate-100 pr-6 space-y-6">
                            @foreach($shipment->statusHistories as $history)
                                <div class="relative">
                                    <div class="absolute -right-[31px] top-1.5 w-4 h-4 rounded-full border-4 border-white shadow-sm
                                        {{ $loop->last ? 'bg-indigo-500 ring-4 ring-indigo-50' : 'bg-slate-300' }}"></div>
                                    <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-slate-800">{{ $history->status->label() }}</span>
                                            <span class="text-xs font-bold text-slate-400 font-mono">{{ $history->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($history->notes)
                                            <p class="text-sm text-slate-500 mt-2 bg-slate-50 p-2 rounded-lg border border-slate-100">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <span class="text-slate-400 font-bold text-sm">لا يوجد سجل تاريخي لهذه الشحنة حتى الآن.</span>
                        </div>
                    @endif
                </div>
                
                <!-- Scroll to result -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById('tracking-result').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                </script>
            @endif
        </div>
    </main>

    <!-- Features Section -->
    <section class="bg-white py-20 border-t border-slate-100 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-4">ليه تختار ShipLink؟</h2>
                <p class="text-slate-500 font-medium">الخيار الأول للتجار والعملاء في المملكة لضمان وصول الشحنات بأمان وسرعة.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-8 rounded-3xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-3">سرعة التوصيل</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">شبكة واسعة من السائقين المحترفين لضمان وصول طلباتك في وقت قياسي.</p>
                </div>
                <div class="p-8 rounded-3xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                    <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-3">أمان وثقة</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">تشفير كامل للبيانات وعملية تتبع شفافة تضمن لك راحة البال من المتجر للباب.</p>
                </div>
                <div class="p-8 rounded-3xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100 group">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-3">دفع مرن</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">خيارات دفع متعددة وآمنة مع دعم كامل لخدمة الدفع عند الاستلام (COD).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-black text-xl">S</div>
                <span class="font-black text-xl text-white tracking-tight">Ship<span class="text-indigo-400">Link</span></span>
            </div>
            <p class="text-sm font-medium">جميع الحقوق محفوظة &copy; {{ date('Y') }} لمنصة ShipLink.</p>
        </div>
    </footer>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
