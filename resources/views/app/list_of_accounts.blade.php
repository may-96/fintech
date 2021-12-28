@extends('layouts.home')



@section('slider')

    <div class="hero-slider-wrapper bg-dark">
        <div class="hero-slider owl-carousel dots-over" data-nav="true" data-dots="true" data-autoplay="true">
            <div class="owl-slide d-flex align-items-center bg-overlay bg-overlay-400" style="background-image: url('{{ url('images/dashboard/bankg1.jpg')}}');">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1 col-lg-7 offset-lg-4 col-xl-6 col-xxl-5 text-center text-lg-start">
                            <h1 class="display-1 fs-56 mb-4  text-white animated-caption" data-anim="animate__slideInDown" data-anim-delay="500">We're not a bank We're better.</h1>
                            <p class="lead fs-23 lh-sm mb-7 text-white animated-caption" data-anim="animate__slideInRight" data-anim-delay="1000">Register here and manage your flow of money efficiently.</p>
                            <div class="animated-caption offset-lg-4" data-anim="animate__slideInUp" data-anim-delay="1500"><a href="#" class="btn btn-lg btn-outline-white rounded-pill">Read More</a></div>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/.container -->
            </div>
            <!--/.owl-slide -->


        </div>
        <!--/.hero-slider -->
    </div>
    <!--/.hero-slider-wrapper -->


@endsection
@section('content')

        <div class="container py-14 py-md-16">
            <div class="row gy-10 gy-sm-13 gx-lg-3 align-items-center">
                <div class="col-md-8 col-lg-6 position-relative">
                    <div class="shape bg-dot primary rellax w-17 h-21" data-rellax-speed="1" style="top: -2rem; left: -1.9rem;"></div>
                    <div class="shape rounded bg-soft-primary rellax d-md-block" data-rellax-speed="0" style="bottom: -1.8rem; right: -1.5rem; width: 85%; height: 90%; "></div>
                    <figure class="rounded"><img src="{{asset('images/photos/about7.jpg')}}" srcset="{{asset('images/photos/about7@2x.jpg 2x')}}" alt="" /></figure>
                </div>
                <!--/column -->
                <div class="col-lg-5 col-xl-4 offset-lg-1">
                    <h2 class="h1 mb-3">How It Link Account?</h2>
                    <p class="lead fs-lg mb-6">So here are three working steps why our valued customers choose us.</p>
                    <div class="d-flex flex-row mb-6">
                        <div>
                            <span class="icon btn btn-circle btn-primary disabled me-5"><span class="number fs-18">1</span></span>
                        </div>
                        <div>
                            <h4 class="mb-1">Collect Ideas</h4>
                            <p class="mb-0">Nulla vitae elit libero pharetra augue dapibus. Praesent commodo cursus.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-row mb-6">
                        <div>
                            <span class="icon btn btn-circle btn-primary disabled me-5"><span class="number fs-18">2</span></span>
                        </div>
                        <div>
                            <h4 class="mb-1">Data Analysis</h4>
                            <p class="mb-0">Vivamus sagittis lacus vel augue laoreet. Etiam porta sem malesuada magna.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <div>
                            <span class="icon btn btn-circle btn-primary disabled me-5"><span class="number fs-18">3</span></span>
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
        </div>
        <!-- /.container -->

    <!-- /section -->
@endsection
@section('sharedaccounts')


          <div class="row py-10">
              <div class="d-flex align-items-center mx-2 bg-overlay rounded bg-overlay-500" style=" background-size: cover; background-image: url('{{ url('images/dashboard/sharedaccnt1.jpg')}}');">
                <div class="col-md-10 offset-md-1 py-10 col-lg-5 col-sm-12 col-md-7 offset-lg-4 col-xl-6 col-xxl-5 text-center text-lg-start">
                    <h3 class="display-1 fs-56 mb-4  text-white animated-caption" >Shared Accounts.</h3>
                    <p class="lead fs-23 lh-sm mb-7 text-indigo animated-caption">Click here to view accounts shared with you.</p>
                    <div class="animated-caption px-5 offset-lg-1" data-anim="animate__slideInUp" data-anim-delay="1500"><a href="#" class="btn btn-lg btn-outline-blue rounded-pill">Read More</a></div>
                </div>
                <!--/column -->
              </div>
            <!--/.row -->
          </div>

    @endsection
@section('linkaccount')


       <div class="row py-10 mx-10">
            <div class="d-flex align-items-center bg-overlay rounded bg-overlay-500" style=" background-size: cover; background-image: url('{{ url('images/dashboard/sharedaccnt1.jpg')}}');">

                <div class="col-md-10 offset-md-1 py-10 col-lg-5 col-sm-12 col-md-4 col-xl-6 col-xxl-5 text-center text-lg-start">
                    <h3 class="display-1 fs-56 mb-4  text-white animated-caption" >Link your Accounts.</h3>
                    <p class="lead fs-23 lh-sm mb-7 text-indigo animated-caption">Click here to view accounts shared with you.</p>
                    <div class="animated-caption px-5 offset-lg-1" data-anim="animate__slideInUp" data-anim-delay="1500"><a href="#" class="btn btn-lg btn-outline-blue rounded-pill">Read More</a></div>
                </div>
            <!--/column -->
            </div>
       </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>

@endsection
