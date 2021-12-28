@extends('layouts.auth')

@section('content')

<<<<<<< HEAD
    <div class="container-fluid px-10" id="sm">
         <div class="row">
             <div class="cols-md-12 pt-3 mb-10 text-start offset-xl-1">
                 <h1 class="text-primary fw-bold fs-28">Revolut</h1>
             </div>
            <div class="d-none d-lg-block col-md-8 col-lg-7 col-xl-6 offset-xl-1">
                <img src="{{asset('/images/login/login.png')}}" class="img-fluid" alt="Phone image">
=======
    <div class="container-fluid px-10 d-flex justify-content-center vh-100" id="sm">
         <div class="row d-flex justify-content-center" style="width: 80rem;">
                <div class="mt-6"><p class="text-primary fs-28 fw-bold">Revolut</p></div>
            <div class="d-flex d-none d-md-block col-md-6">
                <div class="d-flex justify-content-center">
                    <img src="{{asset('/images/login/login.png')}}" class="img img-fluid" alt="Register Image">
                </div>
>>>>>>> origin/landingpage
            </div>
            <div class="col-12 col-md-6">
                <form class="m-auto" style="max-width: 25rem;">
                    <!-- Email input -->
                    <div class="text-dark fs-24 lh-1 fw-bold text-upper text-center mb-6">Create an Account</div>
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

                    <div class="d-flex mt-4 mb-2">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="form1Example3"
                            checked
                        />
                        <p class="text-muted ms-2 fs-14">I agree, to your<a href="#" class="fst-normal"> Terms </a>,<a href="#" class="fst-normal">Privacy Policy </a> and <a href="#" class="fst-normal">Cookie Policy</a></p>

                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-purple col-12">Sign up</button>
                    <p class="mt-2">Already have an account? <a href="{{url('/login')}}"> Sign In</a></p>
                </form>
            </div>
        </div>
    </div>

@endsection
