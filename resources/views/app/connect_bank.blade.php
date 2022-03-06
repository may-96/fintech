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
    <section id="particles-js" class="wrapper vh-100 d-flex align-items-center hero_section_bg">
    </section>
    <div style="top: 40%;" class="position-absolute text-center w-100 ">
        <div class=" text-capitalize">
            <h1 class="display-1 fs-66 mb-4">Link your bank </h1>
            <p class="lead fs-23 lh-sm text-indigo animated-caption">Link your bank and manage all your accounts under one platform</p>
            <a href="#connect_form" id="connect_form_btn" class="btn btn-primary">Connect Bank Account</a>
        </div>
    </div>

@endsection
@section('content')
    <livewire:connect />
@endsection
@section('js')

    <script src="{{asset('js/particles.js')}}"></script>
    <script>
        particlesJS('particles-js',{
            "particles": {
                "number": {
                    "value": 137,
                    "density": {
                        "enable": true,
                        "value_area": 2525.3123101083497
                    }
                },
                "color": {
                    "value": "#338bd9"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#4353cf",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "window",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": false,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 227.75766584354238,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        })
    </script>

    <script src="{{ asset('js/select2.js') }}"></script>

    @livewireScripts
    <script src="{{ asset('js/alpine.js') }}"></script>
    @stack('scripts')
    <script>
        $("#connect_form_btn").click(function() {
            $('html,body').animate({
                    scrollTop: $("#connect_form").offset().top
                },
                'slow');
        });
    </script>
@endsection
