@extends('layouts.auth')

@section('content')

    <div class="container-fluid px-10" id="sm">
         <div class="row">
             <div class="cols-md-12 pt-3 mb-10 text-start offset-xl-1">
                 <h1 class="text-primary fw-bold fs-28">Revolut</h1>
             </div>
            <div class="d-none d-lg-block col-md-8 col-lg-7 col-xl-6 offset-xl-1">
                <img src="{{asset('/images/login/login.png')}}" class="img-fluid" alt="Phone image">
            </div>
            <div class="col-lg-5 col-sm-9 col-xl-4">
                <form>
                    <!-- Email input -->
                    <div class="text-muted">
                        <h1>Sign Up</h1>
                    </div>
                    <div class="form-outline mb-4 d-sm-flex d-md-flex d-lg-flex">
                        <input type="text" id="FirstName" placeholder="First Name" class="form-control me-2" />
                        <input type="text" id="LastName" placeholder="Last Name" class="form-control" />
                    </div>

                    <div class="form-outline mb-4">
                        <input type="email" id="email" placeholder="Email Address" class="form-control " />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" placeholder="New Password" id="pass" class="form-control" />
                    </div>

                    <div class="form-outline mb-1">
                        <input type="password" placeholder="Confirm Password" id="confirm" class="form-control" />
                    </div>

                    <div class="d-flex mb-2">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="form1Example3"
                            checked
                        />
                        <p class="text-muted ms-1 fs-14">I agree, to your<a href="#" class="fst-normal"> Terms </a>,<a href="#" class="fst-normal">Privacy Policy </a> and <a href="#" class="fst-normal">Cookie Policy</a></p>

                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-purple col-12">Sign up</button>
                    <p class="mt-2">if you already've an account? <a href="{{url('/login')}}"> Sign In</a></p>



                </form>
            </div>
        </div>
    </div>

@endsection
