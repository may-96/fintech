<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{ asset ('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset ('css/plugins.css') }}">

</head>
<body>
@yield('topbr')
@yield('slider')
<section class="wrapper bg-light wrapper-border">
@yield('content')
    <div class="container d-flex ">
@yield('sharedaccounts')
    @yield('linkaccount')
    </div>
    </section>
<x-footer></x-footer>
<x-js></x-js>
@yield('js')
</body>
