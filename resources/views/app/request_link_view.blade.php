@extends('layouts.app')
@section('css')
<link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
@livewireStyles
    <style>
        .select2-selection__rendered {
            width: 100% !important;
            padding: 0.6rem 2.25rem 0.6rem 1rem !important;
            -moz-padding-start: calc(1rem - 3px);
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.7 !important;
            color: #959ca9 !important;
            background-color: #fff;
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 8px 8px;
            border: 1px solid rgb(229 233 238);
            border-radius: 0.4rem;
            box-shadow: 0rem 0rem 1.25rem rgb(30 34 40 / 4%);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .select2-container--default .select2-selection--single {
            background-color: unset !important;
            border: unset !important;
            border-radius: 4px;
            height: 100%;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 52px !important;
            top: 0px !important;
            right: 0px !important;
            width: 52px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-radius: 4px;
            border-color: #60697b transparent transparent transparent !important;
            border-width: 6px 5px 0 5px !important;
        }

        .select2-container--open .select2-dropdown--below {
            border-top: 1px solid #aaa !important;
            border-radius: 0px !important;
        }

        .img-flag {
            height: 20px;
            vertical-align: sub;
            margin-right: 6px;
        }

    </style>
@endsection
@section('header')
    <section class="wrapper d-flex align-items-center hero_section_bg pt-16 pb-10" style="">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <div class="post-header text-capitalize">
                        <h1 class="display-1 fs-52 mb-4">Share Your Credit Report</h1>
                    </div>
                    <a href="#form_area" id="form_link_btn" class="btn btn-navy rounded-pill">Navigate to End</a>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <livewire:request-link-view :data="$data" :ip="$ip" />
@endsection

@section('js')
<script src="{{ asset('js/select2.js') }}"></script>
<script>
    $("#form_link_btn").click(function(e) {
        let form = e.target.getAttribute("href");
        $('html,body').animate({
                scrollTop: ($(form).offset().top - 61)
            },
            'slow');
    });
</script>
@livewireScripts
@stack('scripts')
@endsection
