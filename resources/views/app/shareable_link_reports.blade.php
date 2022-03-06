@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
    <link rel="stylesheet" href="{{ asset('css/print.min.css') }}">
    @livewireStyles
@endsection

@section('content')
    <livewire:shareable-link-report :data="$data" />
@endsection

@section('js')
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/print.min.js') }}"></script>
    @livewireScripts
    @stack('scripts')
@endsection
