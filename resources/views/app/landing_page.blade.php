@extends('layouts.app')
@section('header')
    <section class="wrapper py-22 hero_section_bg" style="background-image: url({{asset('images/background/Sprinkle.svg')}})">
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
    <section class="wrapper bg-soft-ash mb-2 my-15 mb-sm-20">
        <div class="container">
            <div class="card mx-sm-10 mx-2 py-5  bg-white">
                <div class="row m-auto gx-md-2 gx-xl-10 gy-8 text-center">
                    <div class="col-lg-9 col-md-7 col-sm-10 col-xl-8 col-xxl-7 mx-auto">
                        <h2 class="fs-15 text-uppercase text-muted mb-3">What We Do?</h2>
                        <h3 class="display-6 mb-9">The service we offer is specifically designed to meet your needs.</h3>
                    </div>
                    <!-- /column -->
                </div>
                <!-- /.row -->
                <div class="row bg-white gx-md-2 gx-xl-10 gy-8  mb-md-16 text-center m-auto">
                    <div class="col-md-4">
                        <div class="icon btn btn-block btn-lg btn-soft-yellow disabled mb-5"> <i class="uil uil-dollar-alt"></i> </div>

                        <h4>Hedge Funds</h4>
                        <p class="mb-3">Fusce dapibus tellus cursus porta tortor condimentum euismod massa justo vehicula sit amet et risus cras.</p>
                        <a href="#hedge" class="more hover link-yellow">Learn More</a>
                    </div>
                    <!--/column -->
                    <div class="col-md-4">
                        <div class="icon btn btn-block btn-lg btn-soft-blue disabled mb-5"> <i class="uil uil-atm-card"></i> </div>
                        <h4>Credit Worthiness</h4>
                        <p class="mb-3">Fusce dapibus tellus cursus porta tortor condimentum euismod massa justo vehicula sit amet et risus cras.</p>
                        <a href="#" class="more hover link-blue">Learn More</a>
                    </div>
                    <!--/column -->
                    <div class="col-md-4">
                        <div class="icon btn btn-block btn-lg btn-soft-green disabled mb-5"> <i class="uil uil-shield-exclamation"></i> </div>
                        <h4>Secure Payments</h4>
                        <p class="mb-3">Fusce dapibus tellus cursus porta tortor condimentum euismod massa justo vehicula sit amet et risus cras.</p>
                        <a href="#" class="more hover link-green">Learn More</a>
                    </div>
                    <!--/column -->

                </div>
                <!--/.row -->
            </div>
        </div>
    </section>
    <section class="wrapper bg-soft-ash mb-2 mb-sm-20">
        <div class="container">
            <div class="row gy-10 gy-sm-13 gx-lg-3 align-items-center mb-14 mb-md-17 mb-lg-19">
                <div class="col-md-8 col-lg-6 position-relative">
                    <figure class="rounded img-fluid"><img src="{{asset('images/landingpage/startup.svg')}}" srcset="{{asset('images/landingpage/startup.svg 2x')}}" alt="" /></figure>
                </div>
                <!--/column -->
                <div class="col-lg-5 col-xl-4 offset-lg-1">
                    <h2 class="display-4 mb-3">How It Works?</h2>
                    <p class="lead fs-lg mb-6">So here are three working steps why our valued customers choose us.</p>
                    <div class="d-flex flex-row mb-6">
                        <div class="col-3">
                            <img class="img img-fluid" src="{{asset('images/landingpage/connect-bank.svg')}}" srcset="{{asset('images/landingpage/connect-bank.svg 2x')}}" alt="" />
                        </div>
                        <div>
                            <h4 class="mb-1">Collect Ideas</h4>
                            <p class="mb-0">Nulla vitae elit libero pharetra augue dapibus. Praesent commodo cursus.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-row mb-6">
                        <div class="col-3">

                            <img class="img img-fluid" src="{{asset('images/landingpage/registeraccount.svg')}}" srcset="{{asset('images/landingpage/registeraccount.svg 2x')}}" alt="" />
                        </div>

                        <div>
                            <h4 class="mb-1">Data Analysis</h4>
                            <p class="mb-0">Vivamus sagittis lacus vel augue laoreet. Etiam porta sem malesuada magna.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="col-3">
                            <img class="img img-fluid" src="{{asset('images/landingpage/reports.svg')}}" srcset="{{asset('images/landingpage/reports.svg 2x')}}" alt="" />
                        </div>

                        <div>
                            <h4 class="mb-1">Finalize Product</h4>
                            <p class="mb-0">Cras mattis consectetur purus sit amet. Aenean lacinia bibendum nulla sed.</p>
                        </div>
                    </div>
                </div>
                <!--/column -->
            </div>
            <!--/.row -->

            <!--card -->
        </div>
        <!--container -->
    </section>


    <!--Use Cases Section -->
    <section class="wrapper bg-soft-ash mb-sm-20 mb-2 ">
        <div class="container">
            <div class="d-flex mx-sm-10 mx-1 flex-column flex-lg-row">
                <div class="d-flex col-12 col-lg-6 bg-dark text-white p-5 justify-content-evenly flex-column">
                    <div class="col-12">
                        <h2 class="fs-15 text-uppercase text-muted mb-3"  id="hedge"  >Use Cases</h2>
                        <h3 class="display-4 mb-5">Transparent Hedge Funds.</h3>
                        <p class="mb-6"> 'Hedge Fund Managers' can have a webpage where they can share their bank account transaction data to investors.Investors who want to invest in the fund would be able to link their own bank account to the fund, so the fund manager can see how much money is on the bank account of the investors in real-time when they do a "capital call" for investors to invest their money into the fund.</p>
                    </div>
                    <div class="row gy-3">
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-primary mb-0">
                                <li><span><i class="uil uil-check"></i></span><span>Efficient way to manage the cash flow.</span></li>
                                <li class="mt-3"><span><i class="uil uil-check"></i></span><span>Hedge Fund Manager can add notes to each transaction.</span></li>
                            </ul>
                        </div>
                        <!--/column -->
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-primary mb-0">
                                <li><span><i class="uil uil-check"></i></span><span>Share bank account transaction data with investors.</span></li>
                                <li class="mt-3"><span><i class="uil uil-check"></i></span><span>Real-time audit of hedge funds based on bank transaction data.</span></li>
                            </ul>
                        </div>
                        <!--/column -->
                    </div>
                </div>
                <div class="d-flex col-12 col-lg-6 mt-7 mt-lg-0">
                    <figure class="hover-scale img-fluid rounded p-1 p-lg-5"><a href="#"> <img src="{{asset('images/landingpage/hedgefunds.png')}}" alt="" /></a></figure>
                </div>
            </div>
        </div>
        <!--container -->
    </section>

    <!--Use Cases Section -->
    <section class="wrapper bg-soft-ash mb-20">
        <div class="container">
            <div class="d-flex flex-sm-column-reverse flex-column-reverse flex-lg-row">
                <div class="d-flex col-lg-5 h-50 ms-sm-10 ms-1 mt-7 mt-lg-0 col-sm-12 col-12">
                    <figure class="hover-scale rounded">
                        <img class="img-fluid " src="{{asset('images/landingpage/UT6.png')}}" /></figure>

                </div>
                <div class="d-flex flex-column ms-sm-10  ms-1 col-sm-12 col-lg-6">
                    <h3 class="display-4 mb-5">Credit Worthiness Report.</h3>
                    <p class="mb-10"> 'Hedge Fund Managers' can have a webpage where they can share their bank account transaction data to investors.Investors who want to invest in the fund would be able to link their own bank account to the fund, so the fund manager can see how much money is on the bank account of the investors in real-time when they do a "capital call" for investors to invest their money into the fund.</p>
                    <div class="row gy-3">
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-primary mb-0">
                                <li><span><i class="uil uil-check"></i></span><span>Efficient way to manage the cash flow.</span></li>
                                <li class="mt-3"><span><i class="uil uil-check"></i></span><span>Hedge Fund Manager can add notes to each transaction.</span></li>
                            </ul>
                        </div>
                        <!--/column -->
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-primary mb-0">
                                <li><span><i class="uil uil-check"></i></span><span>Share bank account transaction data with investors.</span></li>
                                <li class="mt-3"><span><i class="uil uil-check"></i></span><span>Real-time audit of hedge funds based on bank transaction data.</span></li>
                            </ul>
                        </div>
                        <!--/column -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
