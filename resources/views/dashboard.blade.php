<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="32x32" href="https://flowbite.com/docs/favicon-32x32.png">
    <title>@yield('title') - Company</title>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/solid.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/theme_toggle.js') }}"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    @include('layouts.dashboard.navbar')
    @include('layouts.dashboard.aside')
    <main class="p-4 md:ml-64 h-auto pt-20">
        @yield('content')
        @include('layouts.dashboard.footer')
    </main>
</body>
</html>