<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{ asset ('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset ('css/plugins.css') }}">
    @yield('css')

</head>
<body>
    <x-topbar></x-topbar>
    @yield('headr')

    @yield('content')
    <div class="content-wrapper">
        @yield('dashheadr')
        @yield('section')
    </div>
    <x-footer></x-footer>
    <x-js></x-js>
    @yield('js')
</body>
