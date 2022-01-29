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
            <div id="form_area" class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
                <h2 class="h1 fs-46 mb-10 text-center mb-4">Request Report</h2>
                <p>Enter the email address of the accounts for which you want to request a Credit Worthiness and Affordibility Report.</p>
                <small>We will send a notification to the user, after they allow it we will send a report to your email address or you can download it from here.</small>
                <div class="form-floating">
                    <textarea id="request_form" class="form-control" placeholder="Enter Email Addresses" style="height: 250px" required></textarea>
                    <label for="request_form">Please Enter Email Addresses</label>
                </div>
                <div class="mb-4">
                    <small class="text-primary">Enter each email address on new line or with with comma separation.</small>
                </div>
                <div>
                    <a href="#" class="btn btn-soft-primary rounded-pill">Send Requests</a>
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
