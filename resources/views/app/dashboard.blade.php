@extends('layouts.app')
@section('header')
<section class="wrapper vh-100 d-flex align-items-center hero_section_bg" style="background-image: url({{asset('images/background/Meteor.svg')}})">
    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <div class="post-header text-capitalize">
                    <div class="post-category text-line">
                        <a href="#" class="hover" rel="category">Teamwork</a>
                    </div>
                    <h1 class="display-1 fs-66 mb-4">All Bank accounts, at <br> one place</h1>
                    <p class="lead fs-23 lh-sm text-indigo animated-caption">create an account and manage all your Cash flow efficiently</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('content')
    <section class="wrapper mt-12">
        <div class="container pb-14 pb-md-16">
            <div class="d-flex card bg-gray">
                <div class="col-lg-8 g-7 mx-auto">
                    <!--card-->
                    <div class="py-5 card d-flex flex-row col-12 col-sm-12">
                        <div class="p-5 p-sm-10 col-lg-6 text-black align-items-baseline d-flex flex-column">
                            <h3 class="fs-36 text-start">My Accounts.</h3>
                            <p class="display-1 lead fs-23 ">Smart Manager.</p>
                            <div class="animated-caption" data-anim="animate__slideInUp" data-anim-delay="1000"><a href="#" class="btn btn-lg py-0 btn-outline-blue text-indigo rounded-pill">View Accounts</a></div>
                        </div>
                        <!--/column -->
                        <div class="d-flex col-3 py-3 offset-lg-1 d-none d-sm-block d-lg-flex align-items-end bg-white rounded hover-scale">
                            <img class="img img-fluid" src="{{asset('images/dashboard/c.png')}}" alt="">
                        </div>
                    </div>
                    <!--card-->
                    <div class="d-flex flex-row justify-content-between border-radius-lg-top flex-lg-row flex-column col-12">
                        <div class="mt-5 card d-flex bg-gradient-dark col-12 col-lg-5">
                            <div class="p-5 p-sm-10 col-10 text-indigo align-items-baseline d-flex flex-column">
                                <h3 class="fs-36 text-start">Shared Accounts.</h3>
                                <p class="display-2 lead fs-14 ">All the accounts you shared or shared with you</p>
                                <div class="animated-caption mt-2 mt-sm-10" data-anim="animate__slideInUp" data-anim-delay="1000"><a href="#" class="btn btn-lg py-0 btn-outline-blue text-indigo rounded-pill">View Accounts</a></div>
                            </div>
                            <!--/column -->

                        </div>
                        <!--card-->
                        <div class="mt-5 card d-flex bg-navy ms-1 border-4 col-12 col-lg-7" >
                            <div class="p-5 p-sm-10 col-10 text-white align-items-baseline d-flex flex-column">
                                <h3 class="fs-36 text-start text-white">Connect your Bank.</h3>
                                <p class="display-2 lead fs-14 ">All the accounts you shared or shared with you</p>
                                <div class="animated-caption d-flex mt-sm-10 " data-anim="animate__slideInUp" data-anim-delay="1000"><a href="#" class="btn btn-lg py-0 btn-outline-blue text-indigo rounded-pill">View Accounts</a></div>
                            </div>
                            <!--/column -->
                        </div>
                        <!--card-->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->

    <section class="wrapper mt-12">
        <div class="container pb-14 pb-md-16">
            <div class="d-flex card bg-gray">
                <div class="col-lg-8 mx-auto">
    <div class="mb-15">

        <p class="display-1 text-muted text-center fs-18 ">-Loan</p>
        <h3 class="fs-50 text-center">Get Affordability Letter</h3>
        <p class="display-1 text-center fs-18">Looking to rent a house, connect your bank and get affordability report</p>
    </div>

    <div class="py-5 card d-flex flex-column flex-sm-row col-12 col-sm-12" style="background-color: #ee7a3f">
        <div class="p-5 p-sm-10 col-lg-6 text-white align-items-baseline d-flex flex-column">
            <h3 class="fs-36 text-decoration-underline text-white text-start">Credit Score.</h3>
            <p class="fs-14 text-light ">Put your request to get credit score based on your bank transactions for last one year.</p>
            <div class="animated-caption d-flex align-items-end" data-anim="animate__slideInUp" data-anim-delay="1000"><a href="#" class="btn btn-lg py-0 btn-outline-black text-dark rounded-pill">Request...</a></div>
        </div>
        <!--/column -->
        <div class="d-flex col-4 py-3 offset-lg-2 d-none d-sm-block d-lg-flex align-items-end rounded hover-scale"style="background-color: #ee7a3f">
            <img class="img img-fluid p-2" src="{{asset('images/landingpage/ut4.png')}}" alt="">
        </div>
    </div>
                </div> </div></div></section>
@endsection
