@extends('layouts.home')

@section('topbr')
    <header class="wrapper bg-soft-primary">
        <nav class="navbar navbar-expand-lg center-nav transparent position-absolute navbar-dark caret-none">
            <div class="container flex-lg-row flex-nowrap align-items-center">
                <div class="navbar-brand w-100">
                    <a href="./index.html">
                        <img class="logo-dark" src="{{asset('images/logo.png')}}" srcset="{{asset('images/logo@2x.png 2x')}}" alt="" />
                        <img class="logo-light" src="{{asset('images/logo-light.png')}}" srcset="{{asset('images/logo-light@2x.png 2x')}}" alt="" />
                    </a>
                </div>
                <div class="navbar-collapse offcanvas-nav">
                    <div class="offcanvas-header d-lg-none d-xl-none">
                        <a href="./index.html"><img src="{{asset('images/logo-light.png')}}" srcset="{{asset('images/logo-light@2x.png 2x')}}" alt="" /></a>
                        <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close" aria-label="Close"></button>
                    </div>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="#!">Demos</a>
                            <ul class="dropdown-menu mega-menu mega-menu-dark mega-menu-img">
                                <li class="mega-menu-content">
                                    <ul class="row row-cols-1 row-cols-lg-6 gx-0 gx-lg-4 gy-lg-2 list-unstyled">
                                        <li class="col"><a class="dropdown-item" href="./demo1.html">
                                                <figure class="rounded lift d-none d-lg-block"><img src="{{asset('images/demos/mi1.jpg')}}" srcset="{{asset('images/demos/mi1@2x.jpg')}} 2x" alt=""></figure>
                                                <span class="d-lg-none">Demo I</span>
                                            </a></li>
                                        <li class="col"><a class="dropdown-item" href="./demo2.html">
                                                <figure class="rounded lift d-none d-lg-block"><img src="{{asset('images/demos/mi2.jpg')}}" srcset="{{asset('images/demos/mi2@2x.jpg 2x')}}" alt=""></figure>
                                                <span class="d-lg-none">Demo II</span>
                                            </a></li>
                                        <li class="col"><a class="dropdown-item" href="./demo3.html">
                                                <figure class="rounded lift d-none d-lg-block"><img src="{{asset('images/demos/mi3.jpg')}}" srcset="{{asset('images/demos/mi3@2x.jpg 2x')}}" alt=""></figure>
                                                <span class="d-lg-none">Demo III</span>
                                            </a></li>

                                    </ul>
                                    <!--/.row -->
                                </li>
                                <!--/.mega-menu-content-->
                            </ul>
                            <!--/.dropdown-menu -->
                        </li>
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Pages</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#">Services</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a class="dropdown-item" href="./services.html">Services I</a></li>
                                        <li class="nav-item"><a class="dropdown-item" href="./services2.html">Services II</a></li>
                                    </ul>
                                </li>

                                <li class="nav-item"><a class="dropdown-item" href="./pricing.html">Pricing</a></li>
                                <li class="nav-item"><a class="dropdown-item" href="./onepage.html">One Page</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Projects</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="dropdown-item" href="./projects.html">Projects I</a></li>
                                <li class="nav-item"><a class="dropdown-item" href="./projects2.html">Projects II</a></li>

                            </ul>
                        </li>
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Blog</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="dropdown-item" href="./blog.html">Blog without Sidebar</a></li>

                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#!">Blocks</a>
                            <ul class="dropdown-menu mega-menu mega-menu-dark mega-menu-img">
                                <li class="mega-menu-content">
                                    <ul class="row row-cols-1 row-cols-lg-6 gx-0 gx-lg-6 gy-lg-4 list-unstyled">
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/about.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block1.svg" alt=""></div>
                                                <span>About</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/blog.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block2.svg" alt=""></div>
                                                <span>Blog</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/call-to-action.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block3.svg" alt=""></div>
                                                <span>Call to Action</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/clients.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block4.svg" alt=""></div>
                                                <span>Clients</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/contact.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block5.svg" alt=""></div>
                                                <span>Contact</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/facts.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block6.svg" alt=""></div>
                                                <span>Facts</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/faq.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block7.svg" alt=""></div>
                                                <span>FAQ</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/features.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block8.svg" alt=""></div>
                                                <span>Features</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/footer.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block9.svg" alt=""></div>
                                                <span>Footer</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/hero.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block10.svg" alt=""></div>
                                                <span>Hero</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/navbar.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block11.svg" alt=""></div>
                                                <span>Navbar</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/portfolio.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block12.svg" alt=""></div>
                                                <span>Portfolio</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/pricing.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block13.svg" alt=""></div>
                                                <span>Pricing</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/process.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block14.svg" alt=""></div>
                                                <span>Process</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/team.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block15.svg" alt=""></div>
                                                <span>Team</span>
                                            </a>
                                        </li>
                                        <li class="col"><a class="dropdown-item" href="./docs/blocks/testimonials.html">
                                                <div class="rounded img-svg d-none d-lg-block p-4 mb-lg-2"><img class="rounded-0" src="./assets/img/demos/block16.svg" alt=""></div>
                                                <span>Testimonials</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--/.row -->
                                </li>
                                <!--/.mega-menu-content-->
                            </ul>
                            <!--/.dropdown-menu -->
                        </li>
                        <li class="nav-item"><a class="nav-link" href="./docs/index.html">Documentation</a>

                            <!--/.dropdown-menu -->
                        </li>
                    </ul>
                    <!-- /.navbar-nav -->
                </div>
                <!-- /.navbar-collapse -->
                <div class="navbar-other w-100 d-flex ms-auto">
                    <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
                        <li class="nav-item dropdown language-select text-uppercase">
                            <a class="nav-link dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">En</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="dropdown-item" href="#">En</a></li>
                                <li class="nav-item"><a class="dropdown-item" href="#">De</a></li>
                                <li class="nav-item"><a class="dropdown-item" href="#">Es</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="offcanvas-info"><i class="uil uil-info-circle"></i></a></li>
                        <li class="nav-item d-lg-none">
                            <div class="navbar-hamburger"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
                        </li>
                    </ul>
                    <!-- /.navbar-nav -->
                </div>
                <!-- /.navbar-other -->
                <div class="offcanvas-info text-inverse">
                    <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-info-close" aria-label="Close"></button>
                    <a href="./index.html"><img src="{{asset('images/logo-light.png')}}" srcset="{{asset('images/logo-light@2x.png 2x')}}" alt="" /></a>
                    <div class="mt-4 widget">
                        <p>Sandbox is a multipurpose HTML5 template with various layouts which will be a great solution for your business.</p>
                    </div>
                    <!-- /.widget -->
                    <div class="widget">
                        <h4 class="widget-title text-white mb-3">Contact Info</h4>
                        <address> Moonshine St. 14/05 <br /> Light City, London </address>
                        <a href="mailto:first.last@email.com">info@email.com</a><br /> +00 (123) 456 78 90
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
    </header>
    <!-- /header -->
@endsection

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
