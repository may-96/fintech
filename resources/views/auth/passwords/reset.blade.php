@extends('layouts.auth')
@section('css')

@endsection

@section('content')
    <div class="container-fluid px-10 d-flex justify-content-center vh-100">
        <div class="row d-flex justify-content-center" style="width: 80rem;">
            <div class="mt-6">
                <p class="text-primary fs-28 fw-bold"><a href="{{ route('index') }}">{{ config('app.name') }}</a></p>
            </div>
            <div class="d-flex d-none d-md-block col-md-6 align-self-center">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('/images/auth/reset_password.png') }}" class="img img-fluid" alt="Login Image">
                </div>
            </div>
            <div class="col-12 col-md-6 align-self-center">
                <form class="m-auto" style="max-width: 25rem;" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <!-- Email input -->
                    <div class="text-dark fs-24 lh-1 fw-bold text-upper text-center mb-6">Reset Password</div>
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus placeholder="Email Address" autocomplete="email" class="form-control @error('email') is-invalid @enderror" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" placeholder="Password" required autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-outline mb-8">
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirm Password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" />
                    </div>

                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-purple col-12">Reset Password</button>
                </form>
            </div>
            <div class="align-self-end text-center">
                <p class="m-0">&copy; Revolut 2021</p>
                <small>All Rights Reserved</small>
            </div>
        </div>
    </div>
    <x-toast></x-toast>
@endsection

@section('js')

@endsection
