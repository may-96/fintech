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

        .w-max-content {
            width: max-content !important;
        }

        #listuser {
            max-height: 15em;
            overflow-y: auto;
            margin: 0;
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
                <h2 class="fs-15 text-uppercase text-muted text-center mt-15 mb-3">Shared Reports</h2>
                <h3 class="display-4 text-center">List of all the Shared Reports.</h3>
            </div>
            <!-- /.post-header -->
            <div class="row gy-4">
                @forelse ($data as $shared_reports)
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="card p-3 w-100">
                            <div>
                                <div class="d-flex align-items-center justify-content-between fs-16 fw-bold lh-1 mb-0">
                                    <span>{{$shared_reports->fname}} {{$shared_reports->lname}}</span>
                                    <a class="remove_icon ms-2 px-1 text-danger" data-bs-toggle="modal" onclick="$('#modal_remove_btn').attr('data-id','{{ $shared_reports->pivot->token }}')" data-bs-target="#remove_report_modal" title="Remove Report">
                                        <i class="uil uil-times-circle"></i>
                                    </a>
                                    <form class="d-none" id="remove_report_{{ $shared_reports->pivot->token }}" action="{{ route('remove.report', $shared_reports->pivot->token) }}" method="POST">@csrf</form>
                                </div>
                            </div>
                            <div>
                                <p class="m-0 lh-1 fs-14"></p>
                                <div class="d-flex flex-row justify-content-between align-items-center mt-2">
                                    @if(App\Helpers\Functions::not_empty($shared_reports->company))<small class="text-navy float-start">Company: <span class="text-share fw-bold text-capitalize"> $shared_reports->company</span></small>@else<small class="float-start"></small>@endif
                                    <a class="btn small btn-sm btn-soft-ash rounded-pill px-4 py-0 float-end" href="{{route('get.report',$shared_reports->pivot->token)}}">View Report</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        No Credit Reports has been shared with you! Shared Reports will appear here.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <div class="modal fade" id="remove_report_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row">
                        <div class="col-12">
                            <p class="fs-96 lh-1 mb-0">
                                <i class="uil uil-question-circle"></i>
                            </p>
                            <p>Are you sure you want to remove this report</p>
                            <button id="modal_remove_btn" data-id="" class="btn btn-sm btn-soft-red" onclick="$('#remove_report_'+($('#modal_remove_btn').attr('data-id'))).submit()" type="button">Yes</button>
                            <button class="btn btn-sm btn-soft-blue" type="button" data-bs-dismiss="modal" aria-label="Close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/my_accounts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.10.0/js/md5.min.js"></script>
    <script src="{{ asset('js/alpine.js') }}"></script>
@endsection
