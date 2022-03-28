@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
    <link rel="stylesheet" href="{{ asset('css/print.min.css') }}">
    @livewireStyles
    <style>
        table.consistency td{
            font-size: 11px;
            padding: 0.1rem 0.2rem;
        }
        table.consistency th{
            font-size: 12px
        }

        table.consistency tr.account_title td{
            font-weight: bold;
            font-size: 12px
        }

        table.consistency tr.streak_details{
            text-align: center
        }
    </style>
@endsection

@section('content')
    <livewire:reports :data="$data" />
@endsection

@section('js')
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/print.min.js') }}"></script>
    @livewireScripts
    @stack('scripts')
@endsection
