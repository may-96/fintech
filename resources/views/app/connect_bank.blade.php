@extends('layouts.app')
@section('css')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
    @livewireStyles
@endsection

@section('header')
    <section class="wrapper py-22 hero_section_bg" style="background-image: url({{ asset('images/background/Hexagon.svg') }})">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <div class="post-header text-capitalize">
                        <h1 class="display-1 fs-66 mb-4">Link your Bank Account</h1>
                        <p class="lead fs-23 lh-sm text-indigo animated-caption">We're not a bank. <span>We're </span> better.</p>
                    </div>
                    <a href="#" class="btn btn-navy rounded-pill">Connect Your Bank</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <livewire:connect />
@endsection

@section('js')
    <script src="{{ asset('js/select2.js') }}"></script>
    @livewireScripts
    @stack('scripts')
@endsection
