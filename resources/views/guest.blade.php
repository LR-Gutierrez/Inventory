<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="32x32" href="https://flowbite.com/docs/favicon-32x32.png">
    {{-- <link rel="icon" type="image/png" sizes="32x32" href=""> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/solid.css') }}">
    <title>@yield('title') - Company</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/theme_toggle.js') }}"></script>
</head>
<body>
    @include('layouts.guest.header')
    @yield('content')
    @include('layouts.guest.theme_toggle')
    @include('layouts.guest.footer')
</body>
</html>