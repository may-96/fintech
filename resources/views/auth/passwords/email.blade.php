@extends('layouts.auth')
@section('css')

@endsection

@section('content')
    <div class="container-fluid px-10 d-flex justify-content-center vh-100">
        <div class="row d-flex justify-content-center" style="width: 80rem;">
            <div class="mt-6">
                <p class="text-primary fs-28 fw-bold"><a href="{{ route('index') }}">{{ config('app.name') }}</a></p>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('/images/auth/forgot_password.png') }}" style="max-width: 18rem" class="img img-fluid" alt="Password Reset Image">
                </div>
            </div>
            <div class="col-12">
                <form class="m-auto" id="reset_pass_form" style="max-width: 25rem;" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <!-- Email input -->
                    <div class="text-dark fs-24 lh-1 fw-bold text-upper text-center mb-6">Forgot Password!</div>
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Your Email Address" required autocomplete="email" class="form-control @error('email') is-invalid @enderror" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <button type="submit" id="action_btn" class="btn btn-purple col-12">Send Password Reset Link <x-loading id="loader" class="d-none" /></button>
                    <p class="mt-3 text-center">Already have an account? <a href="{{ route('login') }}"> Sign In</a></p>
                </form>
            </div>
            <div class="align-self-end text-center">
                <p class="m-0">&copy; {{ config('app.name') }} 2021</p>
                <small>All Rights Reserved</small>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#reset_pass_form').on('submit', () => {
        document.querySelector('#loader').classList.remove('d-none');
        document.querySelector('#loader').classList.add('d-inline-block');
    });
</script>
@endsection

