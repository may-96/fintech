@extends('layouts.app')
@section('css')
    @livewireStyles
    <style>
        .share_icon {
            cursor: pointer;
            padding: 0.10rem !important;
        }

        .remove_icon {
            cursor: pointer;
        }

        .share_icon:hover {
            transition: linear 1ms;
            background-color: #f1f5fd !important;
            border-radius: 50rem !important;
        }

        .remove_icon:hover {
            transition: linear 1ms;
            background-color: #fae6e7 !important;
            border-radius: 50rem !important;
        }

        .text-share {
            color: #e7a74d !important;
        }

        .ul {
            text-decoration: underline;
        }

        .w-max-content{
            width: max-content !important;
        }

        #listuser {
            max-height: 15em;
            overflow-y: auto;
            margin: 0;
        }

    </style>
@endsection
@section('header')
    <section class="wrapper vh-100 d-flex align-items-center hero-section-bg" style="background-image: url({{ asset('images/background/Animated_Shape.svg') }})">
        <div class="container pb-19 pt-md-14 pb-md-20 text-center">
            <div class="row">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="post-header">
                        <h1 class="display-1 fs-66 mb-4">All Bank accounts, at <br> one place</h1>
                        <p class="lead fs-23 lh-sm mb-7 text-indigo animated-caption">create an account and manage all your Cash flow efficiently</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')

    <livewire:my-accounts :accounts="$accounts" />

    <!-- /section -->
@endsection
@section('js')
    <script src="{{ asset('js/my_accounts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.10.0/js/md5.min.js"></script>
    @livewireScripts
    <script src="{{ asset('js/alpine.js') }}"></script>
    @stack('scripts')
@endsection
