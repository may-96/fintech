@extends('layouts.app')

@section('headr')

    <nav class="navbar navbar-expand-lg classic transparent navbar-light">
        <div class="container flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand w-100">
                <a href="./index.html">
                    <img src="{{ asset('images/logo.png') }}" srcset="{{ asset('images/logo@2x.png 2x')}}" alt=""/>
                </a>
            </div>
            <div class="navbar-collapse offcanvas-nav">
                <div class="offcanvas-header d-lg-none d-xl-none">
                    <a href="./index.html"><img src="{{ asset ('images/logo-light.png')}}" srcset="{{asset ('images/logo-light@2x.png 2')}}x" alt=""/></a>
                    <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close" aria-label="Close"></button>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#">Dropdown</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a class="dropdown-item" href="#">Action</a></li>
                            <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">Dropdown</a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">Dropdown</a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item"><a class="dropdown-item" href="#">Action</a></li>
                                            <li class="nav-item"><a class="dropdown-item" href="#">Another Action</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a class="dropdown-item" href="#">Action</a></li>
                                    <li class="nav-item"><a class="dropdown-item" href="#">Another Action</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="dropdown-item" href="#">Another Action</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Mega Menu</a>
                        <ul class="dropdown-menu mega-menu">
                            <li class="mega-menu-content">
                                <div class="row gx-0 gx-md-3">

                                    <!--/column -->
                                    <div class="col-lg-3">
                                        <h6 class="dropdown-header">Two</h6>

                                    </div>
                                    <!--/column -->
                                    <div class="col-lg-3">
                                        <h6 class="dropdown-header">Three</h6>

                                    </div>
                                    <!--/column -->
                                </div>
                                <!--/.row -->
                            </li>
                            <!--/.mega-menu-content-->
                        </ul>
                        <!--/.dropdown-menu -->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
                </ul>
                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-collapse -->
            <div class="navbar-other ms-lg-4">
                <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
                    <li class="nav-item"><a class="nav-link" data-toggle="offcanvas-info"><i class="uil uil-info-circle"></i></a></li>
                    <li class="nav-item d-none d-md-block">
                        <a href="#" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modal-01">Sign In</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <div class="navbar-hamburger">
                            <button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button>
                        </div>
                    </li>
                </ul>
                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
            <div class="offcanvas-info text-inverse">
                <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-info-close" aria-label="Close"></button>
                <a href="./index.html"><img src="{{asset ('images/logo-light.png')}}" srcset="{{asset('images/logo-light@2x.png 2x')}}" alt=""/></a>
                <div class="mt-4 widget">
                    <p>Sandbox is a multipurpose HTML5 template with various layouts which will be a great solution for your business.</p>
                </div>
                <!-- /.widget -->
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Contact Info</h4>
                    <address> Moonshine St. 14/05 <br/> Light City, London</address>
                    <a href="mailto:first.last@email.com">info@email.com</a><br/> +00 (123) 456 78 90
                </div>
                <!-- /.widget -->
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Learn More</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <!-- /.widget -->
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Follow Us</h4>
                    <nav class="nav social social-white">
                        <a href="#"><i class="uil uil-twitter"></i></a>
                        <a href="#"><i class="uil uil-facebook-f"></i></a>
                        <a href="#"><i class="uil uil-dribbble"></i></a>
                        <a href="#"><i class="uil uil-instagram"></i></a>
                        <a href="#"><i class="uil uil-youtube"></i></a>
                    </nav>
                    <!-- /.social -->
                </div>
                <!-- /.widget -->
            </div>
            <!-- /.offcanvas-info -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- /.navbar -->
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
                    <p class="lead px-lg-7 px-xl-7 px-xxl-6">We're not a bank. <span>We're </span> better.</p>
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


    <div class="content-wrapper ">
        <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
            <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
                <h2 class="h1 fs-46 mb-10 text-center mb-4">Transaction Details</h2>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-secondary" style="border-left: 6px solid #ffeb3b;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="ficon bx pb-0 mb-1 bx-group mr-25">TransactionID</p>
                            <p class="ficon pb-0 mb-1 bx px-6 bx-group mr-25">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">
                            <p class="d-flex mb-1 text-start" style="flex-direction: column;">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 justify-content-between text-start">
                                <textarea style="display: none; resize: none; width: 20rem;" id="note" class="me-1 mt-0 fs-11"></textarea>
                                     <p class="pe-1 fs-12" id="noteapp"></p>

                                <i class="uil pe-6 uil-comment-alt-plus" style="display: block" onclick="makevisible()" id="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note"></i>
                                <i class="uil pe-6 uil-comment-alt-message" style="display: none" onclick="makevisible()" id="save" data-bs-toggle="tooltip" data-bs-placement="right" title="Save"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-secondary" style="border-left: 6px solid #ffeb3b;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="ficon bx pb-0 mb-1 bx-group mr-25">TransactionID</p>
                            <p class="ficon pb-0 mb-1 bx px-6 bx-group mr-25">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">

                            <p class="d-flex mb-1 text-start" style="flex-direction: column;">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 justify-content-between text-start">
                                <textarea style="display: none; resize: none; width: 20rem;" id="note" class="me-1 rounded-1 info mt-0 fs-11"></textarea>
                                <i class="uil pe-6 uil-comment-alt-plus" style="display: block" onclick="makevisible()" id="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note"></i>
                                <i class="uil pe-6 uil-comment-alt-message" style="display: none" onclick="makevisible()" id="save" data-bs-toggle="tooltip" data-bs-placement="right" title="Save"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-secondary" style="border-left: 6px solid #ffeb3b;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="ficon bx pb-0 mb-1 bx-group mr-25">TransactionID</p>
                            <p class="ficon pb-0 mb-1 bx px-6 bx-group mr-25">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <small>Details...</small>
                            <i class="uil px-6 uil-comment-alt-message" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add Note"></i>
                        </div>
                        <p class="d-flex mb-1 align-items-center">
                            <small class="text-muted">12/19/2021 12:02:46 PM</small>
                        </p>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-secondary" style="border-left: 6px solid #ffeb3b;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="ficon bx pb-0 mb-1 bx-group mr-25">TransactionID</p>
                            <p class="ficon pb-0 mb-1 bx px-6 bx-group mr-25">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">
                            <p class="d-flex mb-1 text-start" style="flex-direction: column;">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 justify-content-between text-start">
                                <textarea style="display: none; resize: none; width: 20rem;" id="note" class="me-1 rounded-1 info mt-0 fs-11"></textarea>

                                <i class="uil pe-6 uil-comment-alt-plus" style="display: block" onclick="makevisible()" id="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note"></i>
                                <i class="uil pe-6 uil-comment-alt-message" style="display: none" onclick="makevisible()" id="save" data-bs-toggle="tooltip" data-bs-placement="right" title="Save"></i>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>

@endsection
