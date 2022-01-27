@extends('layouts.app')
@section('header')
    <section id="particles-js" class="wrapper vh-100 d-flex align-items-center hero_section_bg">
    </section>
    <div style="top: 40%;" class="position-absolute text-center w-100 ">
        <div class=" text-capitalize">
            <h1 class="display-1 fs-66 mb-4">Open Banking Account <br> Transparency In EEA+UK</h1>
            <p class="lead fs-23 lh-sm text-indigo animated-caption">Connect Your European Bank Account And Share Your Cash Flow Data Transparently</p>
        </div>
    </div>
@endsection
@section('content')

    <section class="wrapper mt-20">
        <div class="container">
            <div class="card py-12 bg-white">
                <div class="row m-auto text-center">
                    <div class="col-md-10 mx-auto">
                        <h2 class="fs-15 text-uppercase text-muted mb-3">What We Do?</h2>
                        <h3 class="display-6 mb-9">The service we offer is specifically designed to meet your needs.</h3>
                    </div>
                </div>
                <div class="row bg-white gy-8 text-center m-auto">
                    <div class="col-lg-4">
                        <div class="icon btn btn-block btn-lg btn-soft-yellow mb-5">
                            <i class="uil uil-dollar-alt"></i>
                        </div>
                        <h4>Transparent Hedge Funds</h4>
                        <p class="mb-3">Share bank account statement data on how invested money is spent and what the actual returns on investments are in real-time.</p>
                        <a href="#hedge" class="more hover link-yellow">Learn More</a>
                    </div>
                    <div class="col-lg-4">
                        <div class="icon btn btn-block btn-lg btn-soft-green mb-5">
                            <i class="uil uil-atm-card"></i>
                        </div>
                        <h4>Credit Worthiness Analysis</h4>
                        <p class="mb-3"> Analyse Credit Worthiness of clients based on real bank account transaction data.</p>
                        <a href="#credit" class="more hover link-green">Learn More</a>
                    </div>
                    <div class="col-lg-4">
                        <div class="icon btn btn-block btn-lg btn-soft-blue mb-5">
                            <i class="uil uil-shield-exclamation"></i>
                        </div>
                        <h4>Real-Time Audits</h4>
                        <p class="mb-3">Enabling real-time bank account transaction audits for enhanced transparency and trust.</p>
                        <a href="#" class="more hover link-blue">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wrapper mt-20">
        <div class="container">
            <div class="row gx-12">
                <div class="col-md-8 col-lg-6 col-xl-5 m-auto position-relative">
                    <img class="img img-fluid" src="{{asset('images/landingpage/Startup_SVG.svg')}}" srcset="{{asset('images/landingpage/Startup_SVG.svg')}} 2x" alt="">
                </div>
                <div class="col-lg-6 col-xl-6 ">
                    <h2 class="display-4 mb-5">How It Works?</h2>
                    <p class="lead mb-6">So here are three working steps why our valued customers choose us.</p>
                    <div class="card p-3 d-flex flex-row mb-3">
                        <div class="col-sm-3 col-5 pe-3 d-flex">
                            <img class="img img-fluid" src="{{asset('images/landingpage/connect-bank.svg')}}" srcset="{{asset('images/landingpage/connect-bank.svg')}} 2x" alt="">
                        </div>
                        <div class="col-sm-9 col-7">
                            <h5 class="mb-1">Register your Account</h5>
                            <p class="mb-0 fs-14">Register yourself with us and get access to our features.</p>
                        </div>
                    </div>
                    <div class="card p-3 d-flex flex-row mb-3">
                        <div class="col-sm-3 col-5 pe-3 d-flex">

                            <img class="img img-fluid" src="{{asset('images/landingpage/registeraccount.svg')}}" srcset="{{asset('images/landingpage/registeraccount.svg')}} 2x" alt="">
                        </div>

                        <div class="col-sm-9 col-7">
                            <h5 class="mb-1">Link your Bank</h5>
                            <p class="mb-0 fs-14">Connect your bank with us and manage all your accounts under one platform</p>
                        </div>
                    </div>
                    <div class="card p-3 d-flex flex-row mb-6">
                        <div class="col-sm-3 col-5 pe-3 d-flex">
                            <img class="img img-fluid" src="{{asset('images/landingpage/reports.svg')}}" srcset="{{asset('images/landingpage/reports.svg')}} 2x" alt="">
                        </div>

                        <div class="col-sm-9 col-7">
                            <h5 class="mb-1">Manage Cash Flow & Reports</h5>
                            <p class="mb-0 fs-14">Manage your hedge funds or request an analysis on your potential client’s bank account transactions to get a Credit Worthiness Report</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Use Cases Section -->
    <section class="wrapper mt-20">
        <div class="container">
            <div class="d-flex px-sm-10 px-1 flex-column flex-lg-row">
                <div class="d-flex col-12 col-lg-6 flex-column">
                    <div class="col-12">
                        <h2 class="fs-15 text-uppercase text-muted mb-3" id="hedge">Use Cases</h2>
                        <h3 class="display-4 mb-5">Transparent Hedge Funds.</h3>
                        <p class="mb-6">'Hedge Fund Managers' can have a webpage where they can share their bank account transaction data to investors.Investors who want to invest in the fund would be able to link their own bank
                            account to the fund, so the fund manager can see how much money is on the bank account of the investors in real-time when they do a "capital call" for investors to invest their money into the fund.</p>
                    </div>
                    <div class="row gy-3">
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-warning mb-0">
                                <li>
                                    <span>
                                        <i class="uil uil-check"></i>
                                    </span>
                                    <span>Efficient way to manage the cash flow.</span>
                                </li>
                                <li class="mt-3">
                                    <span>
                                        <i class="uil uil-check"></i>
                                    </span>
                                    <span>Hedge Fund Manager can add notes to each transaction.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-warning mb-0">
                                <li>
                                    <span>
                                        <i class="uil uil-check"></i>
                                    </span>
                                    <span>Share bank account transaction data with investors.</span>
                                </li>
                                <li class="mt-3">
                                    <span>
                                        <i class="uil uil-check"></i>
                                    </span>
                                    <span>Real-time audit of hedge funds based on bank transaction data.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center col-12 col-lg-6">
                    <figure class="hover-scale">
                        <img class="img img-fluid p-4" src="{{asset('images/landingpage/hedgefunds.png')}}" alt="">
                    </figure>
                </div>
            </div>
        </div>
    </section>

    <!--Use Cases Section -->
    <section class="wrapper my-20" id="credit">
        <div class="container">
            <div class="d-flex flex-sm-column-reverse flex-column-reverse flex-lg-row">
                <div class="d-flex align-items-center justify-content-center col-12 col-lg-6">
                    <figure class="hover-scale">
                        <img class="img img-fluid p-4" src="{{ asset('images/dashboard/report_2.svg') }}" />
                    </figure>

                </div>
                <div class="d-flex col-12 col-lg-6 flex-column">
                    <div class="col-12">
                        <h3 class="display-4 mb-5">Credit Worthiness Report.</h3>
                        <p class="mb-6">Analyse creditworthiness of potential clients based on real cashflow data from their bank accounts</p>
                    </div>

                    <div class="row gy-3">
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-success mb-0">
                                <li>
                                    <span>
                                        <i class="uil uil-check"></i>
                                    </span>
                                    <span>Analyse monthly income.</span>
                                </li>
                                <li class="mt-3">
                                    <span>
                                        <i class="uil uil-check"></i>
                                    </span>
                                    <span>Calculate affordability.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-6">
                            <ul class="icon-list bullet-bg bullet-soft-success mb-0">
                                <li>
                                    <span>
                                        <i class="uil uil-check"></i>
                                    </span>
                                    <span>Analyse consistency of monthly payments.</span>
                                </li>
                                <li class="mt-3">
                                    <span>
                                        <i class="uil uil-check"></i>
                                    </span>
                                    <span>Custom GDPR compatible privacy settings.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
