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
                    <img src="{{ asset('/images/auth/login.png') }}" class="img img-fluid" alt="Login Image">
                </div>
            </div>
            <div class="col-12 col-md-6 align-self-center">
                <form class="m-auto" style="max-width: 25rem;" id="login_form" method="POST" action="{{route('login')}}">
                    @csrf
                    <!-- Email input -->
                    <div class="text-dark fs-24 lh-1 fw-bold text-upper text-center mb-6">Access Your Account</div>
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
                        <input type="password" id="password" name="password" required placeholder="Password" autocomplete="password" class="form-control @error('password') is-invalid @enderror" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <!-- Checkbox -->
                        <div class="form-check">
                            <input type="checkbox" id="remember" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }} />
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                    </div>

                    <!-- Submit button -->
                    <button type="submit" id="action_btn" class="btn btn-purple col-12">Login <x-loading id="loader" class="d-none" /></button>

                    <div class="text-end mt-2"><a href="{{route('password.request')}}">Forgot password?</a></div>
                    <p class="mt-3">If you don't have an account, <a class="underline" href="{{ route('register') }}"> Register here!</a></p>
                </form>
            </div>
            <div class="align-self-end text-center">
                <p class="m-0">&copy; {{ config('app.name') }} 2022</p>
                <small>All Rights Reserved</small>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#login_form').on('submit', () => {
        document.querySelector('#loader').classList.remove('d-none');
        document.querySelector('#loader').classList.add('d-inline-block');
    });
</script>
@endsection