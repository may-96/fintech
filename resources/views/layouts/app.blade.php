<!doctype html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="user-id" content="{{ Auth::user()->id }}">
    @endauth
    
    <x-css></x-css>
    <link rel="stylesheet" href="{{ asset('css/topbar.css') }}">

    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @yield('css')
</head>

<body>
    
    <x-topbar></x-topbar>
    <div class="content-wrapper bg-soft-ash">
        @yield('header')
        @yield('content')
    </div>
    <x-footer></x-footer>
    <x-toast></x-toast>
    <audio id="notification_sound">
        <source src="{{ asset('audio/notification.mp3') }}">
    </audio>
    <x-js></x-js>
    @yield('js')
</body>
