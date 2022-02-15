@extends('layouts.app')
@section('header')
    <section class="wrapper vh-100 d-flex align-items-center hero_section_bg" style="background-image: url({{ asset('images/background/Meteor.svg') }})">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <div class="post-header text-capitalize">
                        <h1 class="display-1 fs-66 mb-4">All Bank accounts, at <br> one place</h1>
                        <p class="lead fs-23 lh-sm text-indigo animated-caption">create an account and manage all your Cash flow efficiently</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <section class="wrapper mt-20">
        <div class="container">
            <div class="row">
                <div class="col-12 pb-4">
                    <div class="card flex-row p-4 justify-content-start justify-content-md-around">
                        <div class="col-lg-6 d-flex flex-column justify-content-around">
                            <div>
                                <h3 class="fs-36 text-start">My Accounts</h3>
                                <p class="display-2 lead fs-14">Smart Manager</p>
                            </div>
                            <div class="animated-caption" data-anim="animate__slideInUp" data-anim-delay="1000">
                                <a href="{{route('my.accounts')}}" class="btn btn-lg py-0 btn-outline-blue text-indigo rounded-pill">View Accounts</a>
                            </div>
                        </div>
                        <div class="d-none col-4 d-md-flex hover-scale justify-content-around">
                            <img class="img img-fluid w-75" src="{{asset('images/dashboard/c.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="height: 300px;">
                <div class="col-12 col-lg-5 pb-4">
                    <div class="card h-100 p-4 bg-gradient-dark justify-content-around d-flex flex-column">
                        <div>
                            <h3 class="fs-36 text-start">Shared Accounts</h3>
                            <p class="display-2 lead fs-14 ">All the accounts you shared or shared with you</p>
                        </div>
                        <div class="animated-caption" data-anim="animate__slideInUp" data-anim-delay="1000">
                            <a href="{{route('shared.accounts')}}" class="btn btn-lg py-0 btn-outline-blue text-indigo rounded-pill">View Shared Accounts</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7 pb-4">
                    <div class="card h-100 p-4 bg-navy text-white justify-content-around d-flex flex-column">
                        <div>
                            <h3 class="fs-36 text-start text-white">Connect your Bank</h3>
                            <p class="display-2 lead fs-14 ">All the accounts you shared or shared with you</p>
                        </div>
                        <div class="animated-caption" data-anim="animate__slideInUp" data-anim-delay="1000">
                            <a href="{{route('connect_bank')}}" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wrapper mt-20">
        <div class="container">
            <div class="mb-15">
                <h3 class="fs-50 text-center">Get Affordability Letter</h3>
                <p class="display-1 text-center fs-18">Looking to rent a house, connect your bank and get affordability report</p>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card flex-row p-4 justify-content-start justify-content-md-around" style="background: #ee7a3f;">
                        <div class="col-lg-6 d-flex flex-column justify-content-around text-white">
                            <div>
                                <h3 class="fs-36 text-start text-white">Credit Score</h3>
                                <p class="display-2 lead fs-14">Put your request to get credit score based on your bank transactions for last one year.</p>
                            </div>
                            <div class="animated-caption" data-anim="animate__slideInUp" data-anim-delay="1000">
                                <a href="{{route('request.report')}}" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill" title="Request Report using Email ID">Request Report</a>
                                <a href="{{route('get.report')}}" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill" title="Generate Your Account Report">View My Report</a>
                                <a href="#" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill" title="View Shared Reports">Shared Report</a>
                            </div>
                        </div>
                        <!--/column -->
                        <div class="d-none p-2 col-4 d-md-flex hover-scale justify-content-around">
                            <img class="img img-fluid w-75" src="{{ asset('images/dashboard/report_2.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wrapper my-20">
        <div class="container">
            <div class="mb-15">
                <h3 class="fs-50 text-center">Account Management</h3>
                <p class="display-1 text-center fs-18">View and Manage Your Account Settings and Notifications</p>
            </div>
            <div class="row" style="height: 300px;">
                {{-- <div class="col-12 col-lg-6 pb-4">
                    <div class="card h-100 p-4 justify-content-around d-flex flex-column">
                        <div>
                            <h3 class="fs-36 text-start">Notifications</h3>
                            <p class="display-2 lead fs-14 ">Check and Manage All Your Notifications</p>
                        </div>
                        <div class="animated-caption" data-anim="animate__slideInUp" data-anim-delay="1000">
                            <a data-toggle="offcanvas-info" class="btn btn-lg py-0 btn-outline-blue text-indigo rounded-pill">View Notifications</a>
                        </div>
                    </div>
                </div> --}}
                <div class="col-12 col-lg-12 pb-4">
                    <div class="card h-100 p-4 bg-purple text-white justify-content-around d-flex flex-column">
                        <div>
                            <h3 class="fs-36 text-start text-white">Settings</h3>
                            <p class="display-2 lead fs-14">View all the settings related to your account</p>
                        </div>
                        <div class="animated-caption" data-anim="animate__slideInUp" data-anim-delay="1000">
                            <a href="#" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill">Open Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
