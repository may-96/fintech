<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fintech</title>

    <link href="{{asset('css/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('css/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/css/style.css')}}" rel="stylesheet">

</head>

<body>
<x-topbar></x-topbar>

@yield('content')

<x-footer></x-footer>

@yield('js')
</body>
