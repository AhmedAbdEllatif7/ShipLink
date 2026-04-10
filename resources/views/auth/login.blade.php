<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | ShipLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 lg:p-0">

    <div class="max-w-6xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[600px]">
        
        <!-- Form Section -->
        <div class="w-full lg:w-1/2 p-8 lg:p-14 flex flex-col justify-center">
            
            <div class="mb-10 text-center lg:text-right">
                <div class="flex items-center justify-center lg:justify-start gap-2 mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Ship<span class="text-blue-600">Link</span></h1>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">مرحباً بعودتك! 👋</h2>
                <p class="text-slate-500 mt-2 text-sm">قم بتسجيل الدخول للوصول إلى لوحة التحكم الخاصة بك والمتابعة الحية.</p>
            </div>

            <!-- Validation Errors if any -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Account Type Selector -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">اختر نوع الحساب</label>
                    <div class="grid grid-cols-3 gap-3">
                        
                        <!-- Admin -->
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="admin" class="peer sr-only" checked>
                            <div class="rounded-xl border-2 border-slate-100 bg-white p-3 text-center hover:bg-slate-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all duration-200">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="block text-xs font-bold">إدارة</span>
                            </div>
                        </label>

                        <!-- Merchant -->
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="merchant" class="peer sr-only">
                            <div class="rounded-xl border-2 border-slate-100 bg-white p-3 text-center hover:bg-slate-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all duration-200">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="block text-xs font-bold">تاجر</span>
                            </div>
                        </label>

                        <!-- Driver -->
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="driver" class="peer sr-only">
                            <div class="rounded-xl border-2 border-slate-100 bg-white p-3 text-center hover:bg-slate-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all duration-200">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                <span class="block text-xs font-bold">سائق</span>
                            </div>
                        </label>

                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">البريد الإلكتروني</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" name="email" id="email" required autofocus placeholder="name@example.com" class="block w-full pr-10 pl-3 py-3 border-slate-200 rounded-xl text-sm focus:ring-blue-600 focus:border-blue-600 bg-slate-50 focus:bg-white transition-colors duration-200" value="{{ old('email') }}">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-semibold text-slate-700">كلمة المرور</label>
                        <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-700 hover:underline">نسيت كلمة المرور؟</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" id="password" required placeholder="••••••••" class="block w-full pr-10 pl-3 py-3 border-slate-200 rounded-xl text-sm focus:ring-blue-600 focus:border-blue-600 bg-slate-50 focus:bg-white transition-colors duration-200">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="remember_me" class="mr-2 text-sm font-medium text-slate-600">تذكرني على هذا المتصفح</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-blue-500/30">
                    دخول إلى النظام
                </button>
                
                <p class="text-sm font-medium text-slate-500 text-center mt-6">
                    ليس لديك حساب؟ <a href="{{ url('register') }}" class="text-blue-600 hover:underline">سجل كمستخدم جديد</a>
                </p>
            </form>
        </div>

        <!-- Visual/Image Section -->
        <div class="hidden lg:flex w-1/2 relative bg-blue-600 overflow-hidden">
            <!-- Modern abstract geometric shapes -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-indigo-900 opacity-90"></div>
            
            <!-- Glassmorphism Element -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-3/4 max-w-md z-10 text-center">
                <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-8 rounded-3xl shadow-2xl">
                    <svg class="w-16 h-16 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <h3 class="text-2xl text-white font-bold mb-2">الشحن أسرع، أسهل، وأذكى مجتمعين في مكان واحد</h3>
                    <p class="text-blue-100 text-sm leading-relaxed">منصة ShipLink اللوجستية تربط التجار بالسائقين وتُدير عمليات التوصيل بكفاءة وسرعة فائقة باستخدام أحدث التقنيات.</p>
                </div>
            </div>

            <!-- Background dynamic blobs (pure CSS) -->
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-40 -left-20 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-20 left-20 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
        </div>
    </div>

    <style>
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</body>
</html>
