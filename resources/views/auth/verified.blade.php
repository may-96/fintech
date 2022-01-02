@extends('layouts.auth')
@section('css')

@endsection

@section('content')
    <div class="container-fluid px-10 d-flex justify-content-center vh-100">
        <div class="row d-flex justify-content-center" style="width: 80rem;">
            <div class="mt-6">
                <p class="text-primary fs-28 fw-bold text-center"><a href="{{ route('index') }}">{{ config('app.name') }}</a></p>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('/images/auth/email_verified.png') }}" style="max-width: 18rem" class="img img-fluid" alt="Password Reset Image">
                </div>
            </div>
            <div class="col-12">
                <div class="text-success fs-22 fw-bold lh-1 text-capitalize text-center mb-6">
                    @if (session('verified'))
                        Success! Your email has been verified.
                    @else
                        Your email has already been verified!
                    @endif
                </div>
                <div class="text-center"><a href="{{route('index')}}" class="btn btn-purple">Go to Homepage</a></div>
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
