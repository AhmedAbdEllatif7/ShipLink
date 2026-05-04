<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة التاجر | ShipLink</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-emerald-50 text-slate-800 antialiased h-screen flex overflow-hidden">

    <!-- Sidebar -->
    @include('layouts.merchant.sidebar')

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Header -->
        <header class="h-20 bg-white border-b border-emerald-100/50 flex items-center justify-between px-8 z-10 shadow-sm">
            <h2 class="text-xl font-bold text-slate-800">@yield('title', 'نبذة عامة')</h2>
            
            <div class="flex items-center gap-4">
                @include('components.notification-dropdown')
            </div>
        </header>

        <!-- Dynamic Page Content -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-[#f8fafc] bg-[url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%2310b981\' fill-opacity=\'0.03\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E')]">
            @yield('content')
        </div>
    </main>

</body>
</html>
