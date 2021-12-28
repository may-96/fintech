@extends('layouts.auth')

@section('content')

        <div class="container-fluid px-10">
            <div class="row">
                <div class="cols-md-12 pt-3 mb-10 text-start offset-xl-1">
                    <h1 class="text-primary fw-bold fs-28">Revolut</h1>
                </div>
                <div class="d-none d-lg-block col-md-8 col-lg-7 col-xl-6 offset-xl-1">
                    <img src="{{asset('/images/login/login.png')}}" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-lg-5 col-xl-5">
                    <form>
                        <!-- Email input -->
                        <div class="text-muted">
                            <h1>Sign In</h1>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="email" id="form1Example13" class="form-control" />
                            <label class="form-label" for="form1Example13">Email address</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="form1Example23" class="form-control" />
                            <label class="form-label" for="form1Example23">Password</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="form1Example3"
                                    checked
                                />
                                <label class="form-check-label" for="form1Example3"> Remember me </label>
                            </div>
                            <a href="#!">Forgot password?</a>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-purple col-12 btn-lg">Sign in</button>
                        <p class="text-center mt-2">or</p>

                        <p class="mt-1"><a class="underline" href="{{url('/register')}}"> Sign Up</a>.If you don't have an account</p>



                    </form>
                </div>
            </div>
        </div>

@endsection
