<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أدخل كود التحقق | ShipLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        /* Style for OTP inputs to look nice and spaced */
        .otp-input { text-align: center; font-size: 1.5rem; font-weight: bold; letter-spacing: 0.5rem; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 lg:p-0">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 lg:p-10 text-center relative overflow-hidden">
        
        <div class="mb-8">
            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                 <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">أدخل كود التحقق</h2>
            <p class="text-slate-500 mt-2 text-sm leading-relaxed">أرسلنا كوداً مكوناً من 6 أرقام إلى البريد <br> <strong class="text-slate-800">{{ session('pending_register_email') }}</strong></p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm text-right">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status') == 'otp-sent')
             <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-600 text-sm">
                تم إرسال كود التحقق بنجاح!
            </div>
        @endif

        <form action="{{ route('register.verify-otp.submit') }}" method="POST" class="space-y-6">
            @csrf
            
            <input type="hidden" name="email" value="{{ session('pending_register_email') }}">

            <!-- OTP Input -->
            <div>
                <input type="text" name="code" id="code" maxlength="6" required autofocus placeholder="------" class="otp-input block w-full py-4 border border-slate-200 rounded-xl text-slate-800 focus:ring-blue-600 focus:border-blue-600 bg-slate-50 focus:bg-white transition-colors duration-200" autocomplete="off">
            </div>

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all duration-300 shadow-lg hover:shadow-blue-500/30">
                تحقق وتابع التسجيل
            </button>
            
        </form>

        <form action="{{ route('register.send-otp') }}" method="POST" class="mt-4">
             @csrf
             <input type="hidden" name="email" value="{{ session('pending_register_email') }}">
             <p class="text-sm font-medium text-slate-500">
                لم يصلك الكود؟ 
                <button type="submit" class="text-blue-600 hover:underline bg-transparent border-0 cursor-pointer">إعادة الإرسال</button>
            </p>
        </form>

        <div class="mt-4">
             <a href="{{ route('register.email') }}" class="text-sm text-slate-400 hover:text-slate-600 hover:underline">تعديل البريد الإلكتروني</a>
        </div>
    </div>

</body>
</html>
