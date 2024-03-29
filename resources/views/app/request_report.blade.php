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
                        
                        <div class="text-start input-group">
                            <input id="amount" type="number" min="0" value="{{old('amount')}}" name="amount" class="form-control rounded-0 px-2 py-1 @error('amount') is-invalid @enderror" placeholder="Amount to be Paid Per Month (Rent Amount, Mortgage Amount etc)" required>
                            @php $currencies = DB::table('currencies')->select('currency','code')->distinct()->orderBy('code','asc')->get()->flatten(); @endphp
                            <select name="currency" class="form-select rounded-0" placeholder="Select Currency" required>
                                <option disabled value="">Select Currency</option>
    
                                @foreach($currencies as $index => $currency)
                                <option value="{{$currency->code}}" @if(old('currency') == $currency->code) selected @endif>{{ucwords($currency->currency)}} - {{$currency->code}}</option>
                                @endforeach
                            </select>
                            @error('amount')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            @error('currency')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
                    @forelse ($data as $index => $email)
                        <div class="col-12 mb-1 p-1 alert alert-primary d-flex justify-content-between">
                            <span class="ps-1 align-self-center">{{$email}}</span>
                            <a class="remove_icon ms-2 px-1 text-danger align-self-center" style="cursor: pointer;" data-bs-toggle="modal" onclick="$('#modal_remove_btn').attr('data-id','{{ $index }}')" data-bs-target="#remove_report_request_modal" title="Remove Report Request">
                                <i class="uil uil-times-circle"></i>
                            </a>
                            <form class="d-none" id="remove_report_request_{{ $index }}" action="{{ route('remove.report.request') }}" method="POST">@csrf <input type="hidden" name="email" value="{{$email}}" > </form>
                        </div>
                    @empty
                        <div>
                            No pending requests
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        <div class="modal fade" id="remove_report_request_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content text-center">
                    <div class="modal-body">
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="row">
                            <div class="col-12">
                                <p class="fs-96 lh-1 mb-0">
                                    <i class="uil uil-question-circle"></i>
                                </p>
                                <p>Are you sure you want to remove this report request</p>
                                <button id="modal_remove_btn" data-id="" class="btn btn-sm btn-soft-red" onclick="$('#remove_report_request_'+($('#modal_remove_btn').attr('data-id'))).submit()" type="button">Yes</button>
                                <button class="btn btn-sm btn-soft-blue" type="button" data-bs-dismiss="modal" aria-label="Close">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
