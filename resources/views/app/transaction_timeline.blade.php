@extends('layouts.app')
@section('css')
    <style>
        .note_textarea {
            resize: none;
            height: 28px;
        }

        .note_para,
        .note_textarea {
            line-height: 1.3;
        }

        .note_textarea_timeline {
            background: #f5f5f5;
            border: 1px solid #dfe3e7
        }

        .timeline_date {}

        .timeline_date::before {
            content: "\A";
            position: absolute;
            left: -1.25rem;
            top: 0.25rem;
            display: inline-block;
            background: #343f52;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            margin-top: 1.5rem;
        }

        .timeline_transaction {}

        .timeline_transaction::before {
            content: "";
            position: absolute;
            left: -1rem;
            border-left: 2px solid #aab0bc;
            height: 100%;
            height: -webkit-fill-available;
            height: -moz-available;
            height: fill-available;
        }

        .transaction_danger {}

        .transaction_success {}

        .timeline_details {}

        .transaction_success.timeline_details::before,
        .transaction_danger.timeline_details::before {
            left: -1rem;
            content: "\A";
            position: absolute;
            width: 20px;
            height: 3px;
            margin-top: 0.65rem;
        }

        .transaction_success.timeline_details::before {
            background: #6fc0a5;
        }

        .transaction_danger.timeline_details::before {
            background: #e2626b ;
        }



    </style>
@endsection
@section('header')
    <section class="wrapper py-22 hero_section_bg" style="background-image: url({{asset('images/background/Polygon_Luminary.svg')}})">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <div class="post-header text-capitalize">
                        <h1 class="display-1 fs-66 mb-4">Link your Bank Account</h1>
                        <p class="lead fs-23 lh-sm text-indigo animated-caption">We're not a bank. <span>We're </span> better.</p>
                    </div>
                    <a href="#" class="btn btn-navy rounded-pill">Get Started</a>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="content-wrapper ">
        <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
            <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
                <h2 class="h1 fs-46 mb-10 text-center mb-4">Transaction Timeline</h2>

                <div class="timeline">

                    <div class="timeline_transaction position-relative ms-4">
                        <div class="timeline_date text-start fs-14 mb-4 pt-6">12/19/2021</div>

                        <div class="transaction_danger timeline_details">
                            <div class="shadow-lg px-2 py-1 mb-1 bg-body rounded container-fluid">
                                <div class="list-group w-100">
                                    <div class="d-flex w-100 fw-bold text-dark">
                                        <p class="ficon m-0 lh-1 w-100 text-start">
                                            <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                            <span class="mb-1 d-block fs-14">TransactionID</span>
                                            <small class="w-100 text-start">Details...</small>
                                        </p>
                                        <div class="d-flex align-items-end flex-column">
                                            <p class="ficon mb-0 text-danger">10000</p>
                                            <div class="">
                                                <i class="uil uil-comment-alt-plus d-none" onclick="makevisible(1)" id="add_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                   aria-label="Add Note"></i>
                                                <i class="uil uil-comment-alt-edit d-block" onclick="makevisible(1)" id="edit_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                   aria-label="Edit Note"></i>
                                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(1)" id="save_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                   aria-label="Save Note"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex w-100 pb-3 justify-content-between ">
                                <div class="d-flex mt-0 w-100 text-start">
                                    <textarea id="note_textarea_1" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                    <p id="note_display_1" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                </div>
                            </div>
                        </div>
                        <div class="transaction_success timeline_details">
                            <div class="shadow-lg px-2 py-1 mb-1 bg-body rounded container-fluid">
                                <div class="list-group w-100">
                                    <div class="d-flex w-100 fw-bold text-dark">
                                        <p class="ficon m-0 lh-1 w-100 text-start">
                                            <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                            <span class="mb-1 d-block fs-14">TransactionID</span>
                                            <small class="w-100 text-start">Details...</small>
                                        </p>
                                        <div class="d-flex align-items-end flex-column">
                                            <p class="ficon mb-0 text-success">10000</p>
                                            <div class="">
                                                <i class="uil uil-comment-alt-plus d-none" onclick="makevisible(2)" id="add_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                   aria-label="Add Note"></i>
                                                <i class="uil uil-comment-alt-edit d-block" onclick="makevisible(2)" id="edit_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                   aria-label="Edit Note"></i>
                                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(2)" id="save_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                   aria-label="Save Note"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex w-100 pb-3 justify-content-between ">
                                <div class="d-flex mt-0 w-100 text-start">
                                    <textarea id="note_textarea_2" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                    <p id="note_display_2" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                </div>
                            </div>
                        </div>
                        <div class="transaction_success timeline_details">
                            <div class="shadow-lg px-2 py-1 mb-1 bg-body rounded container-fluid">
                                <div class="list-group w-100">
                                    <div class="d-flex w-100 fw-bold text-dark">
                                        <p class="ficon m-0 lh-1 w-100 text-start">
                                            <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                            <span class="mb-1 d-block fs-14">TransactionID</span>
                                            <small class="w-100 text-start">Details...</small>
                                        </p>
                                        <div class="d-flex align-items-end flex-column">
                                            <p class="ficon mb-0 text-success">10000</p>
                                            <div class="">
                                                <i class="uil uil-comment-alt-plus d-none" onclick="makevisible(3)" id="add_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                   aria-label="Add Note"></i>
                                                <i class="uil uil-comment-alt-edit d-block" onclick="makevisible(3)" id="edit_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                   aria-label="Edit Note"></i>
                                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(3)" id="save_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                   aria-label="Save Note"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex w-100 pb-3 justify-content-between ">
                                <div class="d-flex mt-0 w-100 text-start">
                                    <textarea id="note_textarea_3" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                    <p id="note_display_3" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="timeline_transaction position-relative ms-4">
                        <div class="timeline_date text-start fs-14 mb-4 pt-6">12/19/2021</div>
                        
                        <div class="transaction_danger timeline_details">
                            <div class="shadow-lg px-2 py-1 mb-1 bg-body rounded container-fluid">
                                <div class="list-group w-100">
                                    <div class="d-flex w-100 fw-bold text-dark">
                                        <p class="ficon m-0 lh-1 w-100 text-start">
                                            <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                            <span class="mb-1 d-block fs-14">TransactionID</span>
                                            <small class="w-100 text-start">Details...</small>
                                        </p>
                                        <div class="d-flex align-items-end flex-column">
                                            <p class="ficon mb-0 text-danger">10000</p>
                                            <div class="">
                                                <i class="uil uil-comment-alt-plus d-none" onclick="makevisible(4)" id="add_note_4" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                   aria-label="Add Note"></i>
                                                <i class="uil uil-comment-alt-edit d-block" onclick="makevisible(4)" id="edit_note_4" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                   aria-label="Edit Note"></i>
                                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(4)" id="save_note_4" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                   aria-label="Save Note"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex w-100 pb-3 justify-content-between ">
                                <div class="d-flex mt-0 w-100 text-start">
                                    <textarea id="note_textarea_4" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                    <p id="note_display_4" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                </div>
                            </div>
                        </div>
                        <div class="transaction_danger timeline_details">
                            <div class="shadow-lg px-2 py-1 mb-1 bg-body rounded container-fluid">
                                <div class="list-group w-100">
                                    <div class="d-flex w-100 fw-bold text-dark">
                                        <p class="ficon m-0 lh-1 w-100 text-start">
                                            <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                            <span class="mb-1 d-block fs-14">TransactionID</span>
                                            <small class="w-100 text-start">Details...</small>
                                        </p>
                                        <div class="d-flex align-items-end flex-column">
                                            <p class="ficon mb-0 text-danger">10000</p>
                                            <div class="">
                                                <i class="uil uil-comment-alt-plus d-none" onclick="makevisible(5)" id="add_note_5" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                   aria-label="Add Note"></i>
                                                <i class="uil uil-comment-alt-edit d-block" onclick="makevisible(5)" id="edit_note_5" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                   aria-label="Edit Note"></i>
                                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(5)" id="save_note_5" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                   aria-label="Save Note"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex w-100 pb-3 justify-content-between ">
                                <div class="d-flex mt-0 w-100 text-start">
                                    <textarea id="note_textarea_5" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                    <p id="note_display_5" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="timeline_transaction position-relative ms-4">
                        <div class="timeline_date text-start fs-14 mb-4 pt-6">12/19/2021</div>
                        
                        <div class="transaction_success timeline_details">
                            <div class="shadow-lg px-2 py-1 mb-1 bg-body rounded container-fluid">
                                <div class="list-group w-100">
                                    <div class="d-flex w-100 fw-bold text-dark">
                                        <p class="ficon m-0 lh-1 w-100 text-start">
                                            <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                            <span class="mb-1 d-block fs-14">TransactionID</span>
                                            <small class="w-100 text-start">Details...</small>
                                        </p>
                                        <div class="d-flex align-items-end flex-column">
                                            <p class="ficon mb-0 text-success">10000</p>
                                            <div class="">
                                                <i class="uil uil-comment-alt-plus d-none" onclick="makevisible(6)" id="add_note_6" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                   aria-label="Add Note"></i>
                                                <i class="uil uil-comment-alt-edit d-block" onclick="makevisible(6)" id="edit_note_6" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                   aria-label="Edit Note"></i>
                                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(6)" id="save_note_6" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                   aria-label="Save Note"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex w-100 pb-3 justify-content-between ">
                                <div class="d-flex mt-0 w-100 text-start">
                                    <textarea id="note_textarea_6" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                    <p id="note_display_6" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/save_transactions.js') }}"></script>
@endsection
