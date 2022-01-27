<!doctype html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-css></x-css>
    <link rel="stylesheet" href="{{ asset('css/topbar.css') }}">

    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">


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
    <x-js></x-js>
    @yield('js')
</body>
