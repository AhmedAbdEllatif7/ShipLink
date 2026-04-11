<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحقق من بريدك الإلكتروني | ShipLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 lg:p-0">

    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[500px]">
        
        <!-- Form Section -->
        <div class="w-full lg:w-1/2 p-8 lg:p-14 flex flex-col justify-center">
            
            <div class="mb-10 text-center lg:text-right">
                <div class="flex items-center justify-center lg:justify-start gap-2 mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Ship<span class="text-green-600">Link</span></h1>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">تأكيد البريد الإلكتروني 📫</h2>
                <p class="text-slate-500 mt-2 text-sm">قبل إنشاء الحساب، يرجى إدخال بريدك الإلكتروني لنتأكد منه أولاً.</p>
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

            <form action="{{ route('register.send-otp') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">البريد الإلكتروني</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" name="email" id="email" required autofocus placeholder="name@example.com" class="block w-full pr-10 pl-3 py-3 border border-slate-200 rounded-xl text-sm focus:ring-green-600 focus:border-green-600 bg-slate-50 focus:bg-white transition-colors duration-200" value="{{ old('email') }}">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-green-500/30">
                    أرسل كود التحقق (OTP)
                </button>
                
                <p class="text-sm font-medium text-slate-500 text-center mt-6">
                    لديك حساب بالفعل؟ <a href="{{ url('login') }}" class="text-green-600 hover:underline">تسجيل الدخول</a>
                </p>
            </form>
        </div>

        <!-- Visual/Image Section -->
        <div class="hidden lg:flex w-1/2 relative bg-emerald-600 overflow-hidden items-center justify-center">
            <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-teal-900 opacity-90"></div>
            
            <div class="z-10 text-center px-8">
                <svg class="w-24 h-24 text-white mx-auto mb-6 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <h3 class="text-3xl text-white font-bold mb-4">أمان حسابك هو أولويتنا</h3>
                <p class="text-green-100 text-sm leading-relaxed">خطوة واحدة إضافية للتأكد من هويتك وتأمين بياناتك داخل المنصة.</p>
            </div>
            
             <!-- Background dynamic blobs (pure CSS) -->
             <div class="absolute -top-20 -right-20 w-72 h-72 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        </div>
    </div>
    <style>
        .animate-blob { animation: blob 7s infinite; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</body>
</html>
