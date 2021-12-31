@extends('layouts.app')
@section('header')
    <section class="wrapper py-22">
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
    <section class="wrapper bg-soft-ash">
        <div class="container">
            <div class="card mx-10 py-5 my-15 bg-white">
                <div class="row m-auto text-center">
                    <div class="col-lg-9 col-xl-8 col-xxl-7 mx-auto">
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

            <div class="card shadow-none my-n15 my-lg-n17 mb-25 bg-transparent">
                <div class="card-body py-12 py-lg-14 px-lg-11 py-xl-16 px-xl-13">

                    <div class="row gx-md-8 gx-xl-12 gy-10 align-items-center">
                        <div class="col-lg-12 align-items-center">
                            <h2 class="fs-15 text-uppercase text-muted text-center mb-3">How to</h2>
                            <h3 class="display-4 mb-5 text-center">3 working steps to organize our business projects.</h3>
                        </div>
                        <!--/column -->
                        <div class="col-lg-4">
                            <div class="card ms-15 p-5 my-15 bg-white">
                                <div class="d-flex flex-row">
                                    <div>
                                        <span class="icon btn btn-block btn-lg btn-soft-purple disabled mt-1 me-5"><span class="number fs-22">01</span></span>
                                    </div>
                                    <div>
                                        <h4 class="mb-1">Collect Ideas</h4>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->

                    <div class="row gx-lg-8 gx-xl-12 gy-10 mb-14 mb-md-17 align-items-center">

                        <div class="col-lg-6">
                            <h2 class="fs-15 text-uppercase text-muted mb-3" id="hedge">Use Cases</h2>
                            <h3 class="display-4 mb-5">Transparent Hedge Funds.</h3>
                            <p class="mb-6"> 'Hedge Fund Managers' can have a webpage where they can share their bank account transaction data to investors.Investors who want to invest in the fund would be able to link their own bank
                                account to the fund, so the fund manager can see how much money is on the bank account of the investors in real-time when they do a "capital call" for investors to invest their money into the fund.</p>
                            <div class="row gy-3 gx-xl-8">
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
                                        <li class="mt-3"><span><i class="uil uil-check"></i></span><span>Real-time audit of a transparent hedge fund based on bank account transaction data.</span></li>
                                    </ul>
                                </div>
                                <!--/column -->
                            </div>
                            <!--/.row -->
                        </div>
                        <!--/column -->
                        <div class="col-md-12 col-lg-6 col-sm-12">
                            <div style="background-color: #2d3e50" class="card ms-15 p-5 my-15">
                                <div class="d-flex flex-row">
                                    <div>
                                        <img style="max-height: 6em" class="mx-1 rounded" src="{{ asset('images/landingpage/hedge.jpg') }}">
                                    </div>
                                    <div>
                                        <h4 class="mb-1 text-white">Manage Cash Flow</h4>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-8 ms-lg-1">
                                    <div>
                                        <h4 class="mb-1 text-white">Manage Cash Flow</h4>
                                        <p class="mb-0"></p>
                                    </div>
                                    <div>
                                        <img style="max-height: 6em" class="mx-1 rounded" src="{{ asset('images/landingpage/hedge.jpg') }}">
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-8">
                                    <div>
                                        <img style="max-height: 6em" class="mx-1 rounded" src="{{ asset('images/landingpage/hedge.jpg') }}">
                                    </div>
                                    <div>
                                        <h4 class="mb-1 text-white">Finalize Product</h4>
                                        <p class="mb-0 text-white">Cras mattis consectetur purus sit amet massa justo sit amet risus consectetur magna elit.</p>
                                    </div>
                                </div>
                            </div>
                            <!--/column -->
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                    <div class="row gy-10 gx-8 gx-lg-12 mb-14 mb-md-16 align-items-center">
                        <div class="col-md-8 col-lg-6">

                            <div class="card bg-gray p-5 my-15">
                                <div class="d-flex card shadow-lg flex-row">
                                    <div class="hover-scale">
                                        <img style="max-height: 6em" class="hover-scale" src="{{ asset('images/landingpage/house.png') }}">

                                    </div>
                                    <div>
                                        <h4 class="mb-1 ">Want to rent a house</h4>
                                        <p class="mb-0"></p>
                                    </div>
                                </div>
                                <div class="d-flex card flex-row mt-8 ms-lg-1">
                                    <div>
                                        <h4 class="mb-1">Link your account with us</h4>
                                        <p class="mb-0">Vivamus sagittis lacus vel augue laoreet tortor mauris condimentum fermentum.</p>
                                    </div>
                                    <div>
                                        <span class="icon btn btn-block btn-lg btn-soft-green disabled mt-1 me-5"><span class="number fs-22">02</span></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row mt-8">
                                    <div>
                                        <span class="icon btn btn-block btn-lg btn-soft-orange disabled mt-1 me-5"><span class="number fs-22">03</span></span>
                                    </div>
                                    <div>
                                        <h4 class="mb-1">Get Credit Worthiness Report</h4>
                                        <p class="mb-0">Cras mattis consectetur purus sit amet massa justo sit amet risus consectetur magna elit.</p>
                                    </div>
                                </div>

                            </div>
                            <!--/column -->
                        </div>
                        <!--/column -->
                        <!--/column -->
                        <div class="col-lg-6">
                            <h2 class="fs-15 text-uppercase text-muted mb-3">Use Case 2</h2>
                            <h3 class="display-4 mb-7">Get Credit Worthiness Report.</h3>
                            <div class="accordion accordion-wrapper" id="accordionExample">
                                <div class="card plain accordion-item">
                                    <div class="card-header" id="headingOne">
                                        <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Professional Design </button>
                                    </div>
                                    <!--/.card-header -->
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Praesent commodo cursus magna,
                                                vel.</p>
                                        </div>
                                        <!--/.card-body -->
                                    </div>
                                    <!--/.accordion-collapse -->
                                </div>
                                <!--/.accordion-item -->
                                <div class="card plain accordion-item">
                                    <div class="card-header" id="headingTwo">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Top-Notch Support </button>
                                    </div>
                                    <!--/.card-header -->
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Praesent commodo cursus magna,
                                                vel.</p>
                                        </div>
                                        <!--/.card-body -->
                                    </div>
                                    <!--/.accordion-collapse -->
                                </div>
                                <!--/.accordion-item -->
                                <div class="card plain accordion-item">
                                    <div class="card-header" id="headingThree">
                                        <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Header and Slider Options </button>
                                    </div>
                                    <!--/.card-header -->
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <p>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras mattis consectetur purus sit amet fermentum. Praesent commodo cursus magna,
                                                vel.</p>
                                        </div>
                                        <!--/.card-body -->
                                    </div>
                                    <!--/.accordion-collapse -->
                                </div>
                                <!--/.accordion-item -->
                            </div>
                            <!--/.accordion -->
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->

                </div>
                <!--/.card -->
            </div>
            <!-- /.container -->
    </section>
    <!-- /section -->
@endsection
