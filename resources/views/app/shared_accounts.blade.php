@extends('layouts.app')

@section('css')
    @livewireStyles
@endsection

@section('header')
    <section class="wrapper vh-100 d-flex align-items-center hero-section-bg" style="background-image: url({{ asset('images/background/Animated_Shape.svg') }})">
        <div class="container pb-19 pt-md-14 pb-md-20 text-center">
            <div class="row">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="post-header">
                        <h1 class="display-1 mb-3">Account Shared with You</h1>
                        <p>One place to manage all the shared accounts</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')

    <livewire:shared-accounts />

@endsection

@section('js')
    @livewireScripts
    @stack('scripts')
@endsection
