@extends('layouts.auth')
@section('css')

@endsection

@section('content')
    <div class="container-fluid px-10 d-flex justify-content-center vh-100" id="sm">
        <div class="row d-flex justify-content-center" style="width: 80rem;">
            <div class="mt-6">
                <p class="text-primary fs-28 fw-bold"><a href="{{ route('index') }}">{{ config('app.name') }}</a></p>
            </div>
            <div class="d-flex d-none d-md-block col-md-6 align-self-center">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('/images/auth/register.png') }}" class="img img-fluid" alt="Register Image">
                </div>
            </div>
            <div class="col-12 col-md-6 align-self-center">
                <form method="POST" action="{{ route('register') }}" class="m-auto" style="max-width: 25rem;">
                    @csrf
                    <!-- Email input -->
                    <div class="text-dark fs-24 lh-1 fw-bold text-upper text-center mb-6">Create an Account</div>
                    <div class="form-outline mb-4 row">
                        <div class="col-sm-6">
                            <input type="text" id="fname" name="fname" required value="{{ old('fname') }}" placeholder="First Name" autocomplete="given-name" class="form-control @error('fname') is-invalid @enderror" />
                            @error('fname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <input type="text" id="lname" name="lname" required value="{{ old('lname') }}" placeholder="Last Name" autocomplete="family-name" class="form-control @error('lname') is-invalid @enderror" />
                            @error('lname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="Email Address" autocomplete="email" class="form-control @error('email') is-invalid @enderror" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" required placeholder="New Password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-outline mb-1">
                        <input type="password" id="password_confirmation" required name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" />
                    </div>

                    <div class="mt-4 mb-2">
                        <input type="checkbox" id="terms" name="terms" required class="form-check-input @error('terms') is-invalid @enderror" />
                        <label for="terms" class="text-muted ms-2 fs-14">I agree, to your <a href="#" target="_blank" class="fst-normal">Terms</a>, <a href="#" target="_blank" class="fst-normal">Privacy Policy</a> and <a href="#" target="_blank" class="fst-normal">Cookie Policy</a></label>
                        @error('terms')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-purple col-12">Sign up</button>
                    <p class="mt-2">Already have an account? <a href="{{ route('login') }}"> Sign In</a></p>
                </form>
            </div>
            <div class="align-self-end text-center">
                <p class="m-0">&copy; Revolut 2021</p>
                <small>All Rights Reserved</small>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
