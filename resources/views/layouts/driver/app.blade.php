<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'تطبيق السائق | ShipLink')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        /* Hide scrollbar for clean mobile feel */
        ::-webkit-scrollbar { width: 0px; background: transparent; }
    </style>
    @stack('css')
</head>
<body class="bg-gray-100 text-slate-800 antialiased h-screen flex flex-col md:flex-row overflow-hidden pb-16 md:pb-0">

    <!-- Mobile Header -->
    @include('layouts.driver.navbar-mobile')

    <!-- Desktop Sidebar (Hidden on mobile) -->
    @include('layouts.driver.sidebar')

    <!-- Main Content (Scrollable Area) -->
    <main class="flex-1 overflow-y-auto h-full w-full bg-gray-100 p-4 md:p-8">
        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation Bar -->
    @include('layouts.driver.navbar-bottom')

    @stack('js')
</body>
</html>
