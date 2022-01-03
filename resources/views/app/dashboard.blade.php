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
    <section class="wrapper mt-22 bg-light">
        <div class="container pb-14 pb-md-16">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="blog single mt-n17">
                        <div class="card">
                            <div class="card-body">
                                <div class="classic-view">
                                    <article class="post">
                                        <div class="post-content mb-5">
                                            <h2 class="h1 fs-46 text-center mb-4">Get rid of traditional banking</h2>
                                            <div class="row g-6 mt-3 mb-10 light-gallery-wrapper">

                                                <div class="mt-20 col-md-12">
                                                    <div class="d-flex align-items-center bg-overlay rounded bg-overlay-1000"
                                                         style=" background-size: cover;height: 100%; background-image: url('{{ url('images/dashboard/sharedaccnt1.jpg') }}');">

                                                        <div class="col-md-10 offset-0 pt-15 pb-5 col-lg-10 col-sm-12 col-md-4 col-xl-6 col-xxl-5 text-start ">
                                                            <h3 class="fs-36 mb-7 offset-1 text-start text-white animated-caption">My Accounts.</h3>
                                                            <p class="display-1 lead offset-1 fs-23 lh-sm mb-7 text-indigo animated-caption">Smart Manager.</p>
                                                            <div class="animated-caption pt-17 offset-1" data-anim="animate__slideInUp" data-anim-delay="1000"><a href="#" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill">Read
                                                                    More</a></div>
                                                        </div>
                                                        <!--/column -->
                                                    </div>
                                                </div>
                                                <!--/column -->


                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center hover-scale bg-overlay rounded bg-overlay-100"
                                                         style=" background-size: cover;height: 100%; background-image: url('{{ url('images/dashboard/sharedaccnt1.jpg') }}');">
                                                        <div class="col-md-10 offset-0 pt-lg-15 pt-md-8 pt-sm-6 pb-5 col-lg-10 col-sm-12 col-md-4 col-xl-6 col-xxl-5 text-start ">
                                                            <h3 class="fs-36 mb-7 offset-1 text-start text-white animated-caption">Shared Accounts</h3>
                                                            <p class="display-1 lead offset-1 fs-23 lh-sm mb-7 text-indigo animated-caption">Smart Manager.</p>
                                                            <div class="animated-caption pt-17 offset-1" data-anim="animate__slideInUp" data-anim-delay="1000"><a href="#" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill">Read
                                                                    More</a></div>
                                                        </div>
                                                        <!--/column -->
                                                        <div class="col-lg-6 mt-20 mx-14">
                                                            <p>this is div</p>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!--/column -->

                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center bg-overlay rounded bg-overlay-1000"
                                                         style=" background-size: cover;height: 100%; background-image: url('{{ url('images/dashboard/sharedaccnt1.jpg') }}');">
                                                        <div class="col-md-10 offset-0 pt-lg-15 pt-md-8 pt-sm-3 pb-sm-3 col-lg-10 col-sm-12 col-md-10 col-xl-9 col-xxl-5 text-start ">
                                                            <h3 class="fs-36 mb-7 offset-1 text-start text-white animated-caption">Link your Accounts</h3>
                                                            <p class="display-1 lead offset-1 fs-23 lh-sm mb-7 text-indigo animated-caption">Smart Manager.</p>
                                                            <div class="animated-caption pt-17 offset-1" data-anim="animate__slideInUp" data-anim-delay="1000"><a href="#" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill">Read
                                                                    More</a></div>
                                                        </div>
                                                        <!--/column -->
                                                    </div>
                                                </div>
                                                <!--/column -->
                                                <div class="mt-20">
                                                    <div class="post-category text-center">
                                                        <a href="#" class="hover text-center">Rent House</a>
                                                    </div>
                                                    <h2 class="h1 fs-46 text-center mb-4">Get an afd letter</h2>
                                                    <p class="lead fs-23 lh-sm mb-7 text-center text-indigo animated-caption">Get your credit score, an affordability letter to rent a house</p>

                                                </div>
                                                <div class="mt-15 col-md-12">
                                                    <div class="d-flex align-items-center bg-overlay rounded bg-overlay-1000"
                                                         style=" background-size: cover;height: 100%; background-image: url('{{ url('images/dashboard/sharedaccnt1.jpg') }}');">
                                                        <div class="col-md-10 offset-0 pt-lg-15 pt-md-8 pt-sm-6 pb-5 col-lg-10 col-sm-12 col-md-4 col-xl-6 col-xxl-5 text-start ">
                                                            <h3 class="fs-36 mb-7 offset-1 text-start text-white animated-caption">My Accounts.</h3>
                                                            <p class="display-1 lead offset-1 fs-23 lh-sm mb-7 text-indigo animated-caption">Smart Manager.</p>
                                                            <div class="animated-caption pt-17 offset-1" data-anim="animate__slideInUp" data-anim-delay="1000"><a href="#" class="btn btn-lg py-0 btn-outline-white text-indigo rounded-pill">Read
                                                                    More</a></div>
                                                        </div>
                                                        <!--/column -->
                                                    </div>
                                                </div>
                                                <!--/column -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                        <!-- /.post-content -->
                                    </article>
                                    <!-- /.post -->
                                </div>
                                <!-- /.classic-view -->


                                <!-- /.social -->
                                <hr />
                                <h3 class="mb-6">You Might Also Like</h3>
                                <div class="carousel owl-carousel blog grid-view mb-16" data-margin="30" data-dots="true" data-autoplay="false" data-autoplay-timeout="5000"
                                     data-responsive='{"0":{"items": "1"}, "768":{"items": "2"}, "992":{"items": "2"}, "1200":{"items": "2"}}'>
                                    <div class="item">
                                        <article>
                                            <figure class="overlay overlay1 hover-scale rounded mb-5"><a href="#"> <img src="{{ asset('images/photos/b4.jpg') }}" alt="" /></a>
                                                <figcaption>
                                                    <h5 class="from-top mb-0">Read More</h5>
                                                </figcaption>
                                            </figure>
                                            <div class="post-header">
                                                <div class="post-category text-line">
                                                    <a href="#" class="hover" rel="category">Coding</a>
                                                </div>
                                                <!-- /.post-category -->
                                                <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Ligula tristique quis risus</a></h2>
                                            </div>
                                            <!-- /.post-header -->
                                            <div class="post-footer">
                                                <ul class="post-meta mb-0">
                                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>14 Apr 2021</span></li>
                                                    <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>4</a></li>
                                                </ul>
                                                <!-- /.post-meta -->
                                            </div>
                                            <!-- /.post-footer -->
                                        </article>
                                        <!-- /article -->
                                    </div>
                                    <!-- /.item -->
                                    <div class="item">
                                        <article>
                                            <figure class="overlay overlay1 hover-scale rounded mb-5"><a href="#"> <img src="{{ asset('images/photos/b5.jpg') }}" alt="" /></a>
                                                <figcaption>
                                                    <h5 class="from-top mb-0">Read More</h5>
                                                </figcaption>
                                            </figure>
                                            <div class="post-header">
                                                <div class="post-category text-line">
                                                    <a href="#" class="hover" rel="category">Workspace</a>
                                                </div>
                                                <!-- /.post-category -->
                                                <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Nullam id dolor elit id nibh</a></h2>
                                            </div>
                                            <!-- /.post-header -->
                                            <div class="post-footer">
                                                <ul class="post-meta mb-0">
                                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>29 Mar 2021</span></li>
                                                    <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>3</a></li>
                                                </ul>
                                                <!-- /.post-meta -->
                                            </div>
                                            <!-- /.post-footer -->
                                        </article>
                                        <!-- /article -->
                                    </div>
                                    <!-- /.item -->
                                    <div class="item">
                                        <article>
                                            <figure class="overlay overlay1 hover-scale rounded mb-5"><a href="#"> <img src="{{ asset('images/photos/b6.jpg') }}" alt="" /></a>
                                                <figcaption>
                                                    <h5 class="from-top mb-0">Read More</h5>
                                                </figcaption>
                                            </figure>
                                            <div class="post-header">
                                                <div class="post-category text-line">
                                                    <a href="#" class="hover" rel="category">Meeting</a>
                                                </div>
                                                <!-- /.post-category -->
                                                <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Ultricies fusce porta elit</a></h2>
                                            </div>
                                            <!-- /.post-header -->
                                            <div class="post-footer">
                                                <ul class="post-meta mb-0">
                                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>26 Feb 2021</span></li>
                                                    <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>6</a></li>
                                                </ul>
                                                <!-- /.post-meta -->
                                            </div>
                                            <!-- /.post-footer -->
                                        </article>
                                        <!-- /article -->
                                    </div>
                                    <!-- /.item -->
                                    <div class="item">
                                        <article>
                                            <figure class="overlay overlay1 hover-scale rounded mb-5"><a href="#"> <img src="{{ asset('images/photos/b7.jpg') }}" alt="" /></a>
                                                <figcaption>
                                                    <h5 class="from-top mb-0">Read More</h5>
                                                </figcaption>
                                            </figure>
                                            <div class="post-header">
                                                <div class="post-category text-line">
                                                    <a href="#" class="hover" rel="category">Business Tips</a>
                                                </div>
                                                <!-- /.post-category -->
                                                <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html">Morbi leo risus porta eget</a></h2>
                                            </div>
                                            <div class="post-footer">
                                                <ul class="post-meta mb-0">
                                                    <li class="post-date"><i class="uil uil-calendar-alt"></i><span>7 Jan 2021</span></li>
                                                    <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>2</a></li>
                                                </ul>
                                                <!-- /.post-meta -->
                                            </div>
                                            <!-- /.post-footer -->
                                        </article>
                                        <!-- /article -->
                                    </div>
                                    <!-- /.item -->
                                </div>
                                <!-- /.owl-carousel -->


                                <hr />


                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-md-8 col-lg-6 position-relative">
                                            <div class="shape rounded bg-soft-secondary rellax d-md-block" data-rellax-speed="0" style="bottom: -1.8rem; right: -1.5rem; width: 85%; height: 90%; "></div>
                                            <figure class="rounded"><img src="{{ asset('images/photos/device.png') }}" srcset="{{ asset('images/photos/about7@2x.jpg 2x') }}" alt="" /></figure>
                                        </div>
                                        <!--/column -->
                                        <div class="col-lg-6 col-xl-4 offset-lg-1">
                                            <h2 class="h1 mb-3">How It Works?</h2>
                                            <div class="d-flex flex-row mb-6">
                                                <div>
                                                    <span class="icon btn btn-circle btn-secondary disabled me-5"><span class="number fs-18">1</span></span>
                                                </div>
                                                <div>
                                                    <h4 class="mb-1">step 1</h4>
                                                    <p class="mb-0">this is 1.</p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row mb-6">
                                                <div>
                                                    <span class="icon btn btn-circle btn-secondary disabled me-5"><span class="number fs-18">2</span></span>
                                                </div>
                                                <div>
                                                    <h4 class="mb-1">step 2</h4>
                                                    <p class="mb-0">this is 2</p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row">
                                                <div>
                                                    <span class="icon btn btn-circle btn-secondary disabled me-5"><span class="number fs-18">3</span></span>
                                                </div>
                                                <div>
                                                    <h4 class="mb-1">step 3</h4>
                                                    <p class="mb-0">this is 3</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/column -->
                                    </div>
                                    <!--/.row -->
                                </div>
                                <!-- /.container -->


                                <hr />


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.blog -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
@endsection
