@extends('layouts.app')
@section('css')
    @endsection
@section('headr')
    <div class="modal fade" id="modal-01" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h3 class="mb-4">Login to Sandbox</h3>
                    <form class="text-start mb-3">
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control" placeholder="Email" id="loginEmail">
                            <label for="loginEmail">Email</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" placeholder="Password" id="loginPassword">
                            <label for="loginPassword">Password</label>
                        </div>
                        <a class="btn btn-primary rounded-pill btn-login w-100 mb-2">Log In</a>
                    </form>
                    <!-- /form -->
                    <p class="mb-1"><a href="#" class="hover">Forgot Password?</a></p>
                    <p class="mb-0">Don't have an account? <a href="#" class="hover">Sign up</a></p>
                    <div class="divider-icon my-4">or</div>
                    <nav class="nav social justify-content-center text-center">
                        <a href="#" class="btn btn-circle btn-sm btn-google"><i class="uil uil-google"></i></a>
                        <a href="#" class="btn btn-circle btn-sm btn-facebook-f"><i class="uil uil-facebook-f"></i></a>
                        <a href="#" class="btn btn-circle btn-sm btn-twitter"><i class="uil uil-twitter"></i></a>
                    </nav>
                    <!--/.social -->
                </div>
                <!--/.modal-content -->
            </div>
            <!--/.modal-body -->
        </div>
        <!--/.modal-dialog -->
    </div>
    <!--/.modal -->



    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
            <div class="row">
                <div class="col-md-8 col-lg-7 col-xl-6 col-xxl-5 mx-auto mb-11">
                    <h1 class="display-1 mb-3">Link your Bank Account</h1>
                    <p class="lead px-lg-7 px-xl-7 px-xxl-6">We're not a bank. <span class="underline">We're </span> better.</p>
                </div>
                <!-- /column -->
            </div>
            <a href="#" class="btn btn-navy rounded-pill">Get Started</a>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>


  @endsection

@section('content')
    <section class="wrapper bg-light">
        <div class="container py-14 py-md-16">
            <h2 class="display-4 mb-3 text-center">My Accounts</h2>
            <p class="lead fs-lg mb-10 text-center px-md-16 px-lg-21 px-xl-0">Here are the list of the Bank Accounts that you have added.</p>
            <div class="post-header">
                <div class="post-category text-line">
                    <a href="#" class="hover" rel="category">Bank Name</a>
                </div>
                <!-- /.post-category -->
                <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="./blog-post.html"></a></h2>
            </div>
            <!-- /.post-header -->

            <div class="carousel owl-carousel blog grid-view" data-margin="30" data-dots="true" data-autoplay="false" data-autoplay-timeout="5000" data-responsive='{"0":{"items": "1"}, "768":{"items": "2"}, "992":{"items": "2"}, "1200":{"items": "3"}}'>
                <div class="item">
                    <article>
                        <figure class="overlay overlay1 hover-scale rounded mb-5"><a href="#"> <img src="{{asset('images/photos/b4.jpg')}}" alt="" /></a>
                            <figcaption>
                                <h5 class="from-top mb-0">Read More</h5>
                            </figcaption>
                        </figure>
                        <div class="post-footer">
                            <ul class="post-meta">
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
                        <figure class="overlay overlay1 hover-scale rounded mb-5"><a href="#"> <img src="{{asset('images/photos/b5.jpg')}}" alt="" /></a>
                            <figcaption>
                                <h5 class="from-top mb-0">Read More</h5>
                            </figcaption>
                        </figure>

                        <div class="post-footer">
                            <ul class="post-meta">
                                <li class="post-date"><i class="uil uil-calendar-alt"></i><span>29 Mar 2021</span></li>
                                <li class="post-comments"><a href="#"><i class="uil uil-comment"></i>3</a></li>
                            </ul>
                            <!-- /.post-meta -->
                        </div>
                        <!-- /.post-footer -->
                    </article>
                    <!-- /article -->
                </div>

            </div>
            <!-- /.owl-carousel -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->

@endsection
@section('js')

@endsection
