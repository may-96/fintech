@extends('layouts.app')
@section('css')
    <style>
        .share_icon {
            cursor: pointer;
            padding: 0.10rem !important;
        }

        .remove_icon {
            cursor: pointer;
        }

        .share_icon:hover {
            transition: linear 1ms;
            background-color: #f1f5fd !important;
            border-radius: 50rem !important;
        }

        .remove_icon:hover {
            transition: linear 1ms;
            background-color: #fae6e7 !important;
            border-radius: 50rem !important;
        }

        .text-share {
            color: #e7a74d !important;
        }

        .ul {
            text-decoration: underline;
        }

    </style>
@endsection
@section('header')
    <section class="wrapper vh-100 d-flex align-items-center hero-section-bg" style="background-image: url({{ asset('images/background/Animated_Shape.svg') }})">
        <div class="container pb-19 pt-md-14 pb-md-20 text-center">
            <div class="row">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="post-header">
                        <h1 class="display-1 fs-66 mb-4">All Bank accounts, at <br> one place</h1>
                        <p class="lead fs-23 lh-sm mb-7 text-indigo animated-caption">create an account and manage all your Cash flow efficiently</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="wrapper bg-soft-ash mb-2 mb-sm-20">
        <div class="container">
            <div class="col-lg-12 mb-15 align-items-center">
                <h2 class="fs-15 text-uppercase text-muted text-center mb-3">My Bank Account</h2>
                <h3 class="display-4 text-center">List of all the linked Accounts.</h3>
            </div>
            @forelse ($accounts as $key => $account)
                @php
                    $institution = App\Models\Institution::find($key);
                @endphp
                <div class="post-category text-line @if (!$loop->first) mt-12 @endif">
                    <a href="#" class="hover" rel="category">{{ $institution->name }}</a>
                    @foreach ($account as $temp)
                        @if ($loop->first)
                            <a class="remove_icon ms-2 px-1 text-danger" data-bs-toggle="modal" onclick="$('#modal_remove_btn').attr('data-id',{{ $temp->requisition_id }})" data-bs-target="#remove_bank_access_modal" title="Remove Account"><i
                                   class="uil uil-times-circle"></i></a>
                            <form class="d-none" id="remove_bank_access_{{ $temp->requisition_id }}" action="{{ route('remove.bank', $temp->requisition_id) }}" method="POST">@csrf</form>
                        @else
                            @break
                        @endif
                    @endforeach
                </div>
                <!-- /.post-header -->
                <div class="row gy-4">
                    @foreach ($account as $a)
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="card p-3 w-100">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between fs-16 fw-bold lh-1 mb-0">
                                        <span>@if (isset($a->iban)) {{ $a->iban }} @elseif(isset($a->bban)) {{ $a->bban }} @else {{ $a->resource_id }} @endif</span>
                                        <span>
                                            <a data-bs-toggle="modal" data-bs-target="#shareform" data-toggle="tooltip" data-placement="top" title="Share" class="share_icon fs-18"><i class="uil uil-share-alt"></i></a>
                                        </span>
                                    </div>
                                    <p class="mb-6 text-primary">@if (isset($a->owner_name)) {{ $a->owner_name }} @else {{ $a->display_naem }} @endif</p>
                                </div>
                                <div>
                                    @if (isset($a->account_name))<p class="m-0 lh-1 fs-14">{{ $a->account_name }}</p>@endif
                                    <div class="clearfix">
                                        <small class="text-muted float-start">Currency: <span class="text-dark">{{ $a->currency }}</span></small>
                                        @if (isset($a->type_string))<small class="text-muted float-end">Type: <span class="text-dark">{{ $a->type_string }}</span></small>@endif
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-2">
                                        @if ($loop->first || $a->shared_with_count > 0)<small class="text-navy float-start">Shared With: <span class="text-share fw-bold">{{ $a->shared_with_count }} Users</span></small>@else<small></small>@endif
                                        <a class="btn small btn-sm btn-soft-ash rounded-pill px-4 py-0 float-end" href="{{ route('my.transactions', $a->account_id) }}">View Transactions</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="row">
                    <div class="col-12">
                        No accounts has yet been connected! Connected Accounts will appear here.
                    </div>
                </div>
            @endforelse

            @if(count($accounts) > 0)
            <div class="modal fade" id="remove_bank_access_modal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content text-center">
                        <div class="modal-body">
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="row">
                                <div class="col-12">
                                    <p class="fs-96 lh-1 mb-0"><i class="uil uil-question-circle"></i></p>
                                    <p>Are you sure you want to remove access to this bank</p>
                                    <button id="modal_remove_btn" data-id="" class="btn btn-sm btn-soft-red" onclick="$('#remove_bank_access_'+($('#modal_remove_btn').attr('data-id'))).submit()" type="button">Yes</button>
                                    <button class="btn btn-sm btn-soft-blue" type="button" data-bs-dismiss="modal" aria-label="Close">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="shareform">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-center">
                        <div class="modal-body">
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                            <h5 class="text-start"> Share with people</h5>
                            <form class="text-start mb-3">
                                <div class=" d-flex">
                                    <input type="email" id="textarea" class="p-1 form-control" placeholder="Email" id="user">
                                    <button id="addUserBtn" class="btn-sm bg-navy py-0 mx-3"><i class="uil p-0 uil-user-plus text-white"></i></button>
                                </div>
                                <p class="text-muted border-bottom fs-11 ms-2">Shared with</p>
                                <div id="listuser" class="d-block">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    </section>
    <!-- /section -->
@endsection
@section('js')

    <script src="{{ asset('js/my_accounts.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.10.0/js/md5.min.js"></script>
@endsection
