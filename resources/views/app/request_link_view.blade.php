@extends('layouts.app')
@section('css')
    <style>
    </style>
@endsection
@section('header')
    <section class="wrapper d-flex align-items-center hero_section_bg pt-16" style="">
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
    <div class="content-wrapper ">

        <section class="wrapper">
            <div class="container pt-10 pb-10 pt-md-14">
                <div class="card py-12 bg-white">
                    <div class="row text-center">
                        <div class="col-md-10 mx-auto">
                            <h2 class="fs-24 text-uppercase text-muted mb-3">How it Works</h2>
                            <h3 class="fs-16">Share Your Credit Report in Few Easy Steps</h3>
                        </div>
                    </div>
                    <div class="row bg-white gy-8 text-center m-auto">
                        <div class="col-lg-4">
                            <div class="icon btn btn-block btn-lg btn-soft-yellow mb-5">
                                <i class="uil uil-sign-in-alt"></i>
                            </div>
                            <h4>Login/Register</h4>
                            <p class="mb-3">Login to your Account or Register a new Account via simple and user friendly form.</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="icon btn btn-block btn-lg btn-soft-green mb-5">
                                <i class="uil uil-cloud-data-connection"></i>
                            </div>
                            <h4>Connect Bank</h4>
                            <p class="mb-3">Connect your bank account in few clicks. You just have to choose your country and bank that's it.</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="icon btn btn-block btn-lg btn-soft-blue mb-5">
                                <i class="uil uil-share-alt"></i>
                            </div>
                            <h4>Share Report</h4>
                            <p class="mb-3">After your bank details are fetched your can share your credit report by just one click.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="wrapper">
            <div class="container pt-10 pb-10 pt-md-14">
                <div class="card">
                    <div class="card-header px-5 p-3 fw-bold fs-18">Details</div>
                    <div class="card-body px-5 p-3">
                        <p>
                            Amount to be paid per Month: <strong>{{ $data->currency }} {{ $data->amount }}</strong>
                        </p>
                        <pre style="white-space: pre-wrap; font-family: Manrope, sans-serif; padding: 0; line-height: 1.3;">{!! nl2br($data->details) !!}</pre>
                    </div>
                </div>
            </div>
        </section>
        

        @guest
            <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30">
                <div id="form_area" class="container pt-10 pb-10 pt-md-14 text-center">
                    <h2 class="h1 fs-36 mb-3 text-center mb-4">Login/Register</h2>
                    <p>Please login or register your account to share the report. After registration you have to connect your bank account as well.</p>
                    <a href="{{route('login')}}" class="btn btn-soft-primary rounded-pill mx-1">Login</a> <a href="{{route('register')}}" class="btn btn-navy rounded-pill mx-1">Register</a>
                </div>
            </section>
        @endguest

        @auth
            @if(auth()->user()->accounts()->count() > 0)
            <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
                <div id="form_area" class="container pt-10 pb-10 pt-md-14">
                    <h2 class="h1 fs-36 mb-3 text-center mb-4">Share Report</h2>
                    <p class="mb-4 text-center">Select things you want to share in the report.</p>
                    <form action="{{route('report.grant.access.link')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                                <input name="credit_score" id="credit_score" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                                <label class="form-check-label mb-2 fs-14 text-start" for="credit_score">Can View Credit Score</label>
                            </div>
                            <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                                <input name="cash_flow" id="cash_flow" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                                <label class="form-check-label mb-2 fs-14 text-start" for="cash_flow">Can View Cash Flow</label>
                            </div>
                            <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                                <input name="expenses" id="expenses" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                                <label class="form-check-label mb-2 fs-14 text-start" for="expenses">Can View Expenses</label>
                            </div>
                            <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                                <input name="income" id="income" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                                <label class="form-check-label mb-2 fs-14 text-start" for="income">Can View Income</label>
                            </div>
                            <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                                <input name="email_check" id="email_check" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                                <label class="form-check-label mb-2 fs-14 text-start" for="email_check">Can View Email</label>
                            </div>
                            <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                                <input name="contact" id="contact" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                                <label class="form-check-label mb-2 fs-14 text-start" for="contact">Can View Contact #</label>
                            </div>
                            <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                                <input name="initials_only" id="initials_only" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                                <label class="form-check-label mb-2 fs-14 text-start" for="initials_only">Initials of the Name</label>
                            </div>
                            <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                                <input name="account_initials_only" id="account_initials_only" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                                <label class="form-check-label mb-2 fs-14 text-start" for="account_initials_only">Initials of the Account Name</label>
                            </div>
                            <input type="hidden" value="{{$data->link}}" name="link">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-soft-primary rounded-pill" type="submit">Share Report</button>
                        </div>
                    </form>
    
                </div>
            </section>
            @else
            <section class="wrapper text-center pb-lg-15 pb-md-20 pb-sm-30">
                <div id="form_area" class="container pt-10 pb-10 pt-md-14 text-center">
                    <h2 class="h1 fs-36 mb-3 text-center mb-4">Connect Bank</h2>
                    <p>Please connect your bank account to share your credit report.</p>
                    <a href="{{route('connect_bank')}}" class="btn btn-soft-primary rounded-pill">Connect Bank</a>
                </div>
            </section>
            @endif
        @endauth

    </div>
@endsection

@section('js')
<script>
    $("#form_link_btn").click(function(e) {
        let form = e.target.getAttribute("href");
        $('html,body').animate({
                scrollTop: ($(form).offset().top - 61)
            },
            'slow');
    });
</script>
@endsection
