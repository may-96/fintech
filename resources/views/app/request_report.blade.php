@extends('layouts.app')
@section('css')
    <style>
    </style>
@endsection
@section('header')
    <section class="wrapper vh-100 d-flex align-items-center hero_section_bg" style="background-image: url({{ asset('images/background/Polygon_Luminary.svg') }})">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <div class="post-header text-capitalize">
                        <h1 class="display-1 fs-66 mb-4">Request Credit Affordibility and Worthiness Report</h1>
                        <p class="lead fs-23 lh-sm text-indigo animated-caption">We're not a bank. <span>We're </span> better.</p>
                    </div>
                    <a href="#form_area" id="form_link_btn" class="btn btn-navy rounded-pill">Navigate to Form</a>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="content-wrapper ">
        <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
            <div id="form_area" class="container pt-10 pb-10 pt-md-14 text-center">
                <h2 class="h1 fs-46 mb-10 text-center mb-4">Request Report</h2>
                <p class="mb-0">Enter the email address of the accounts for which you want to request a Credit Worthiness and Affordibility Report.</p>
                <small>We will send a notification to the user, after they share the credit report then you can download it by logging into your account.</small>
                <form action="{{route('request.report.submit')}}" method="post">
                    @csrf
                    <div class="mt-5 mb-3">
                        <div class="text-start">
                            <input id="amount" type="number" min="0" value="{{old('amount')}}" name="amount" class="form-control px-2 py-1 @error('amount') is-invalid @enderror" placeholder="Amount (in ($) dollars) to Repay Per Month (Rent Amount, Mortgage Amount etc)" required>
                            @error('amount')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    <div class="form-floating">
                        <textarea id="request_form" name="emails" class="form-control" placeholder="Enter Email Addresses" style="height: 250px" required>{{old('emails')}}</textarea>
                        <label for="request_form">Please Enter Email Addresses</label>
                    </div>
                    <div class="mb-4">
                        <small class="text-primary">Enter each email address on new line or with with comma separation.</small>
                    </div>
                    <div>
                        <button class="btn btn-soft-primary rounded-pill" type="submit">Send Requests</button>
                    </div>
                </form>

            </div>
            <div class="container">
                <div class="row"><h5>Pending Requests</h5></div>
                <div class="row ps-4">
                    @forelse ($data as $email)
                        <div class="col-12 mb-1 p-1 alert alert-primary">
                            <span class="ps-1">{{$email}}</span>
                        </div>
                    @empty
                        <div>
                            No pending requests
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
<script>
    $("#form_link_btn").click(function(e) {
        let form = e.target.getAttribute("href");
        $('html,body').animate({
                scrollTop: ($(form).offset().top - 61)
            },
            'slow');
    });
</script>
@endsection
