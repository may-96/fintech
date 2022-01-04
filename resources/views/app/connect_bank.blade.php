@extends('layouts.app')
@section('css')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
    @livewireStyles
    <style>
        .select2-selection__rendered{
            display: block;
            width: 100% !important;
            padding: 0.6rem 2.25rem 0.6rem 1rem !important;
            -moz-padding-start: calc(1rem - 3px);
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.7 !important;
            color: #959ca9 !important;
            background-color: #fff;
            background-image: url(data:image/svg+xml,%3csvg version='1.1' xmlns='http://www.w3.org/2000/svg' width='45' height='32' viewBox='0 0 45 32'%3e%3cpath fill='%2360697b' d='M26.88 29.888c-1.076 1.289-2.683 2.103-4.48 2.103s-3.404-0.814-4.472-2.093l-0.008-0.009-5.12-7.040-8.192-10.048-3.52-4.608c-0.646-0.848-1.036-1.922-1.036-3.087 0-2.828 2.292-5.12 5.12-5.12 0.139 0 0.277 0.006 0.413 0.016l-0.018-0.001h33.664c0.118-0.010 0.256-0.015 0.396-0.015 2.828 0 5.12 2.292 5.12 5.12 0 1.165-0.389 2.239-1.045 3.1l0.009-0.013-3.52 4.608-7.872 10.048z'/%3e%3c/svg%3e);
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 8px 8px;
            border: 1px solid rgba(8, 60, 130, 0.06);
            border-radius: 0.4rem;
            box-shadow: 0rem 0rem 1.25rem rgb(30 34 40 / 4%);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;

        }
    </style>
@endsection

@section('header')
    <section id="particles-js" class="wrapper vh-100 d-flex align-items-center hero_section_bg" >

    </section>
    <div style="top: 40%;" class="position-absolute text-center w-100 ">


        <div class=" text-capitalize">
            <h1 class="display-1 fs-66 mb-4">Link your bank </h1>
            <p class="lead fs-23 lh-sm text-indigo animated-caption">Link your bank and manage all your accounts under one platform</p>
        </div>


    </div>

@endsection
@section('content')
    <livewire:connect />
@endsection
@section('js')

    <script src="{{ asset('js/select2.js') }}"></script>

    @livewireScripts
    @stack('scripts')
@endsection
