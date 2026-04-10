<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل حساب جديد | ShipLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 lg:p-0">

    <div class="max-w-6xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[600px] my-8">
        
        <!-- Form Section -->
        <div class="w-full lg:w-1/2 p-8 lg:p-14 flex flex-col justify-center">
            
            <div class="mb-8 text-center lg:text-right">
                <div class="flex items-center justify-center lg:justify-start gap-2 mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Ship<span class="text-green-600">Link</span></h1>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">إنشاء حساب جديد ✨</h2>
                <p class="text-slate-500 mt-2 text-sm">انضم الآن وابدأ في إدارة أعمالك اللوجستية بسهولة تامة.</p>
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

            <form action="{{ url('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Account Type Selector -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">اختر نوع التسجيل</label>
                    <div class="grid grid-cols-2 gap-3">
                        
                        <!-- Merchant -->
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="merchant" class="peer sr-only" checked>
                            <div class="rounded-xl border-2 border-slate-100 bg-white p-3 text-center hover:bg-slate-50 peer-checked:border-green-600 peer-checked:bg-green-50 peer-checked:text-green-700 transition-all duration-200">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-400 peer-checked:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="block text-xs font-bold">تاجر جديد</span>
                            </div>
                        </label>

                        <!-- Driver -->
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="driver" class="peer sr-only">
                            <div class="rounded-xl border-2 border-slate-100 bg-white p-3 text-center hover:bg-slate-50 peer-checked:border-green-600 peer-checked:bg-green-50 peer-checked:text-green-700 transition-all duration-200">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-400 peer-checked:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                <span class="block text-xs font-bold">سائق مندوب</span>
                            </div>
                        </label>

                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">الاسم الكامل</label>
                        <input type="text" name="name" id="name" required placeholder="أحمد عبدالله" class="block w-full px-3 py-3 border border-slate-200 rounded-xl text-sm focus:ring-green-600 focus:border-green-600 bg-slate-50 focus:bg-white transition-colors duration-200" value="{{ old('name') }}">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" required placeholder="name@example.com" class="block w-full px-3 py-3 border border-slate-200 rounded-xl text-sm focus:ring-green-600 focus:border-green-600 bg-slate-50 focus:bg-white transition-colors duration-200" value="{{ old('email') }}">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1">رقم الهاتف</label>
                        <input type="tel" name="phone" id="phone" required placeholder="01xxxxxxxxx" class="block w-full px-3 py-3 border border-slate-200 rounded-xl text-sm focus:ring-green-600 focus:border-green-600 bg-slate-50 focus:bg-white transition-colors duration-200" value="{{ old('phone') }}">
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-slate-700 mb-1">العنوان</label>
                        <input type="text" name="address" id="address" required placeholder="المدينة، الحي، الشارع" class="block w-full px-3 py-3 border border-slate-200 rounded-xl text-sm focus:ring-green-600 focus:border-green-600 bg-slate-50 focus:bg-white transition-colors duration-200" value="{{ old('address') }}">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">كلمة المرور</label>
                        <input type="password" name="password" id="password" required placeholder="••••••••" class="block w-full px-3 py-3 border border-slate-200 rounded-xl text-sm focus:ring-green-600 focus:border-green-600 bg-slate-50 focus:bg-white transition-colors duration-200">
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="••••••••" class="block w-full px-3 py-3 border border-slate-200 rounded-xl text-sm focus:ring-green-600 focus:border-green-600 bg-slate-50 focus:bg-white transition-colors duration-200">
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start mt-2">
                    <div class="flex items-center h-5">
                        <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 bg-slate-50 rounded border border-slate-300 focus:ring-3 focus:ring-green-300" required>
                    </div>
                    <div class="ml-3 rtl:mr-3 text-sm">
                        <label for="terms" class="font-medium text-slate-700">أوافق على <a href="#" class="text-green-600 hover:underline">الشروط والأحكام</a> وسياسة الخصوصية.</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-green-500/30 mt-4">
                    إنشاء حساب جديد
                </button>
                
                <p class="text-sm font-medium text-slate-500 text-center mt-6">
                    لديك حساب بالفعل؟ <a href="{{ url('login') }}" class="text-green-600 hover:underline">سجل دخولك من هنا</a>
                </p>
            </form>
        </div>

        <!-- Visual/Image Section -->
        <div class="hidden lg:flex w-1/2 relative bg-green-600 overflow-hidden">
            <!-- Modern abstract geometric shapes -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-emerald-900 opacity-90"></div>
            
            <!-- Glassmorphism Element -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-3/4 max-w-md z-10 text-center">
                <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-8 rounded-3xl shadow-2xl">
                    <svg class="w-16 h-16 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-2xl text-white font-bold mb-2">ابدأ رحلتك اللوجستية الآن</h3>
                    <p class="text-green-100 text-sm leading-relaxed">انضم إلى آلاف التجار والسائقين وابدأ في إدارة عمليات شحنك بكفاءة ودقة لا مثيل لها.</p>
                </div>
            </div>

            <!-- Background dynamic blobs (pure CSS) -->
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute top-40 -left-20 w-72 h-72 bg-green-400 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-20 left-20 w-72 h-72 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000"></div>
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
