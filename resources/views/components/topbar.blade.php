<header class="wrapper">
    <nav class="navbar navbar-expand-lg center-nav transparent navbar-light caret-none navbar-custom-style">
        <div class="container flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand me-4">
                <a href="{{ route('index') }}">
                    <p class="text-primary fs-28 fw-bold mb-0">{{ config('app.name') }}</p>
                </a>
            </div>
            <div class="navbar-collapse offcanvas-nav">
                <div class="offcanvas-header d-lg-none d-xl-none">
                    <a href="{{ route('index') }}"><img src="./assets/img/logo-light.png" srcset="./assets/img/logo-light@2x.png 2x" alt="" /></a>
                    <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close" aria-label="Close"></button>
                </div>
                <ul class="navbar-nav nvb">
                    <li class="nav-item"><a class="nav-link" href="{{route('connect_bank')}}">Connect Bank</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('my.accounts') }}">My Accounts</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Shared Accounts</a></li>
                        <li class="nav-item d-block d-xs-none"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item d-block d-xs-none"><a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();">Logout</a></li>
                    @endauth
                    @guest
                        <li class="nav-item d-block d-xs-none"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item d-block d-xs-none"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endguest
                </ul>
                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-collapse -->
            <div class="navbar-other d-flex ms-auto">
                <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">

                    @auth
                        <li class="nav-item d-none d-xs-block">
                            <nav class="nav social soihboardal-muted justify-content-end text-end">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">Dashboard</a>
                            </nav>
                        </li>
                        <li class="nav-item d-none d-xs-block">
                            <nav class="nav social social-muted justify-content-end text-end">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();" class="btn bg-white btn-circle me-2"><i class="uil uil-power text-red"></i></a>
                            </nav>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                    @endauth

                    @guest
                        <li class="nav-item d-none d-xs-block">
                            <nav class="nav social social-muted justify-content-end text-end">
                                <a href="{{ route('login') }}" class="btn btn-white">Login</a>
                            </nav>
                        </li>
                        <li class="nav-item d-none d-xs-block">
                            <nav class="nav social social-muted justify-content-end text-end">
                                <a href="{{ route('register') }}" class="btn btn-dark">Register</a>
                            </nav>
                        </li>
                    @endguest

                    <li class="nav-item d-lg-none">
                        <div class="navbar-hamburger"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
                    </li>
                </ul>
                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- /.navbar -->
</header>
<!-- /header -->
