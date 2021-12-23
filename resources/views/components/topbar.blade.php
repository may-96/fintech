<nav class="navbar navbar-expand-lg classic transparent navbar-light">
    <div class="container flex-lg-row flex-nowrap align-items-center">
        <div class="navbar-brand w-100">
            <a href="./index.html">
                <img src="{{ asset('images/logo.png') }}" srcset="{{ asset('images/logo@2x.png 2x')}}" alt="" />
            </a>
        </div>
        <div class="navbar-collapse offcanvas-nav">
            <div class="offcanvas-header d-lg-none d-xl-none">
                <a href="./index.html"><img src="{{ asset ('images/logo-light.png')}}" srcset="{{asset ('images/logo-light@2x.png 2')}}x" alt="" /></a>
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
                            <div class="row gx-0 gx-lg-3">
                                <div class="col-lg-6">
                                    <h6 class="dropdown-header">One</h6>
                                    <div class="row gx-0">
                                        <div class="col-lg-6">
                                            <ul class="list-unstyled">
                                                <li><a class="dropdown-item" href="#">Link</a></li>
                                                <li><a class="dropdown-item" href="#">Link</a></li>
                                                <li><a class="dropdown-item" href="#">Link</a></li>
                                            </ul>
                                        </div>
                                        <!--/column -->
                                        <div class="col-lg-6">
                                            <ul class="list-unstyled">
                                                <li><a class="dropdown-item" href="#">Link</a></li>
                                                <li><a class="dropdown-item" href="#">Link</a></li>
                                                <li><a class="dropdown-item" href="#">Link</a></li>
                                            </ul>
                                        </div>
                                        <!--/column -->
                                    </div>
                                    <!--/.row -->
                                </div>
                                <!--/column -->
                                <div class="col-lg-3">
                                    <h6 class="dropdown-header">Two</h6>
                                    <ul class="list-unstyled">
                                        <li><a class="dropdown-item" href="#">Link</a></li>
                                        <li><a class="dropdown-item" href="#">Link</a></li>
                                        <li><a class="dropdown-item" href="#">Link</a></li>
                                    </ul>
                                </div>
                                <!--/column -->
                                <div class="col-lg-3">
                                    <h6 class="dropdown-header">Three</h6>
                                    <ul class="list-unstyled">
                                        <li><a class="dropdown-item" href="#">Link</a></li>
                                        <li><a class="dropdown-item" href="#">Link</a></li>
                                        <li><a class="dropdown-item" href="#">Link</a></li>
                                    </ul>
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
                    <div class="navbar-hamburger"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
                </li>
            </ul>
            <!-- /.navbar-nav -->
        </div>
        <!-- /.navbar-other -->
        <div class="offcanvas-info text-inverse">
            <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-info-close" aria-label="Close"></button>
            <a href="./index.html"><img src="{{asset ('images/logo-light.png')}}" srcset="{{asset('images/logo-light@2x.png 2x')}}" alt="" /></a>
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
