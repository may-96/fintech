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

        .timeline_date {
            background: #f2f5fa;
        }
        .timeline_date::before {
            content: "\A";
            position: absolute;
            margin-top: 0.45rem;
            margin-left: 0.25rem;
            display: inline-block;
            background: #343f52;
            border-radius: 50%;
            width: 8px;
            height: 8px;
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
            background: #e2626b;
        }
        .lh1_3 {
            line-height: 1.3 !important;
        }
        .timeline_year_wrapper::before {
            content: attr(data-before-content);

        }
        .timeline_navigation{
            top: 65px;
            position: sticky;
            font-family: monospace;
        }
        .timeline_content_holder{
            max-height: 750px;
            overflow-y: auto;
        }
        .timeline_content_holder::-webkit-scrollbar {
            width: 0;  /* Remove scrollbar space */
            background: transparent;  /* Optional: just make scrollbar invisible */
        }
        .timeline_content_holder::-webkit-scrollbar-thumb {
            background: #FF0000;
        }


    </style>
@endsection
@section('header')
    <section class="wrapper vh-100 d-flex align-items-center hero_section_bg" style="background-image: url({{ asset('images/background/Polygon_Luminary.svg') }})">
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
                

                <div class="row timeline">
                    <div class="col-12 col-md-11 offset-md-1">
                        <h2 class="h1 fs-46 mb-10 text-center mb-4">Transaction Timeline</h2>
                    </div>
                    <div class="d-none d-md-block col-md-1 text-start position-relative">
                        <div class="timeline_navigation mt-6">
                            <a class="year_links d-block" href="#2021">2021</a>
                            <a class="year_links d-block" href="#2020">2020</a>
                        </div>
                    </div>

                    <div class="col-12 col-md-11 timeline_content_holder position-relative">
                        <div class="timeline_year_wrapper" data-before-content="2021" id="2021">
                            <div class="timeline_year border border-secondary my-1">
                                <div class="daily_timeline">
                                    <div class="timeline_date text-start fs-14 py-1"><span class="ms-4">19 December 2021</span>
                                    </div>

                                    <div class="timeline_details">
                                        <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                            <div class="list-group w-100">
                                                <div class="d-flex w-100 fw-bold text-dark">
                                                    <p class="ficon m-0 w-100 lh1_3 text-start">
                                                        <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                                        <span class="mb-1 d-block fs-14">TransactionID</span>
                                                        <small class="w-100 text-start">Details...</small>
                                                    </p>
                                                    <div class="d-flex align-items-end flex-column justify-content-between">
                                                        <p class="ficon mb-0 text-danger">10000</p>
                                                        <div class="">
                                                            <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(1)" id="add_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                               aria-label="Add Note"></i>
                                                            <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(1)" id="edit_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                               aria-label="Edit Note"></i>
                                                            <i class="uil uil-comment-alt-message d-none" onclick="makevisible(1)" id="save_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                               aria-label="Save Note"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between mt-2">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea id="note_textarea_1" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                                    <p id="note_display_1" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="timeline_details">
                                        <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                            <div class="list-group w-100">
                                                <div class="d-flex w-100 fw-bold text-dark">
                                                    <p class="ficon m-0 lh1_3 w-100 text-start">
                                                        <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                                        <span class="mb-1 d-block fs-14">TransactionID</span>
                                                        <small class="w-100 text-start">Details...</small>
                                                    </p>
                                                    <div class="d-flex align-items-end flex-column justify-content-between">
                                                        <p class="ficon mb-0 text-success">10000</p>
                                                        <div class="">
                                                            <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(2)" id="add_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                               aria-label="Add Note"></i>
                                                            <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(2)" id="edit_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                               aria-label="Edit Note"></i>
                                                            <i class="uil uil-comment-alt-message d-none" onclick="makevisible(2)" id="save_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                               aria-label="Save Note"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between mt-2">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea id="note_textarea_2" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                                    <p id="note_display_2" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="timeline_details">
                                        <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                            <div class="list-group w-100">
                                                <div class="d-flex w-100 fw-bold text-dark">
                                                    <p class="ficon m-0 lh1_3 w-100 text-start">
                                                        <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                                        <span class="mb-1 d-block fs-14">TransactionID</span>
                                                        <small class="w-100 text-start">Details...</small>
                                                    </p>
                                                    <div class="d-flex align-items-end flex-column justify-content-between">
                                                        <p class="ficon mb-0 text-success">10000</p>
                                                        <div class="">
                                                            <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(3)" id="add_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                               aria-label="Add Note"></i>
                                                            <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(3)" id="edit_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                               aria-label="Edit Note"></i>
                                                            <i class="uil uil-comment-alt-message d-none" onclick="makevisible(3)" id="save_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                               aria-label="Save Note"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between mt-2">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea id="note_textarea_3" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                                    <p id="note_display_3" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="daily_timeline">
                                    <div class="timeline_date text-start fs-14 py-1"><span class="ms-4">05 November 2021</span>
                                    </div>

                                    <div class="timeline_details">
                                        <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                            <div class="list-group w-100">
                                                <div class="d-flex w-100 fw-bold text-dark">
                                                    <p class="ficon m-0 w-100 lh1_3 text-start">
                                                        <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                                        <span class="mb-1 d-block fs-14">TransactionID</span>
                                                        <small class="w-100 text-start">Details...</small>
                                                    </p>
                                                    <div class="d-flex align-items-end flex-column justify-content-between">
                                                        <p class="ficon mb-0 text-danger">10000</p>
                                                        <div class="">
                                                            <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(4)" id="add_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                               aria-label="Add Note"></i>
                                                            <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(4)" id="edit_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                               aria-label="Edit Note"></i>
                                                            <i class="uil uil-comment-alt-message d-none" onclick="makevisible(4)" id="save_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                               aria-label="Save Note"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between mt-2">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea id="note_textarea_1" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                                    <p id="note_display_1" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="timeline_details">
                                        <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                            <div class="list-group w-100">
                                                <div class="d-flex w-100 fw-bold text-dark">
                                                    <p class="ficon m-0 lh1_3 w-100 text-start">
                                                        <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                                        <span class="mb-1 d-block fs-14">TransactionID</span>
                                                        <small class="w-100 text-start">Details...</small>
                                                    </p>
                                                    <div class="d-flex align-items-end flex-column justify-content-between">
                                                        <p class="ficon mb-0 text-success">10000</p>
                                                        <div class="">
                                                            <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(5)" id="add_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                               aria-label="Add Note"></i>
                                                            <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(5)" id="edit_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                               aria-label="Edit Note"></i>
                                                            <i class="uil uil-comment-alt-message d-none" onclick="makevisible(5)" id="save_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                               aria-label="Save Note"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between mt-2">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea id="note_textarea_2" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                                    <p id="note_display_2" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="timeline_year_wrapper" data-before-content="2020" id="2020">
                            <div class="timeline_year border border-secondary my-1">
                                <div class="daily_timeline">
                                    <div class="timeline_date text-start fs-14 py-1"><span class="ms-4">19 December 2020</span>
                                    </div>

                                    <div class="timeline_details">
                                        <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                            <div class="list-group w-100">
                                                <div class="d-flex w-100 fw-bold text-dark">
                                                    <p class="ficon m-0 w-100 lh1_3 text-start">
                                                        <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                                        <span class="mb-1 d-block fs-14">TransactionID</span>
                                                        <small class="w-100 text-start">Details...</small>
                                                    </p>
                                                    <div class="d-flex align-items-end flex-column justify-content-between">
                                                        <p class="ficon mb-0 text-danger">10000</p>
                                                        <div class="">
                                                            <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(6)" id="add_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                               aria-label="Add Note"></i>
                                                            <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(6)" id="edit_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                               aria-label="Edit Note"></i>
                                                            <i class="uil uil-comment-alt-message d-none" onclick="makevisible(6)" id="save_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                               aria-label="Save Note"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between mt-2">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea id="note_textarea_1" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                                    <p id="note_display_1" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="daily_timeline">
                                    <div class="timeline_date text-start fs-14 py-1"><span class="ms-4">05 November 2021</span>
                                    </div>

                                    <div class="timeline_details">
                                        <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                            <div class="list-group w-100">
                                                <div class="d-flex w-100 fw-bold text-dark">
                                                    <p class="ficon m-0 w-100 lh1_3 text-start">
                                                        <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                                        <span class="mb-1 d-block fs-14">TransactionID</span>
                                                        <small class="w-100 text-start">Details...</small>
                                                    </p>
                                                    <div class="d-flex align-items-end flex-column justify-content-between">
                                                        <p class="ficon mb-0 text-danger">10000</p>
                                                        <div class="">
                                                            <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(7)" id="add_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                               aria-label="Add Note"></i>
                                                            <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(7)" id="edit_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                               aria-label="Edit Note"></i>
                                                            <i class="uil uil-comment-alt-message d-none" onclick="makevisible(7)" id="save_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                               aria-label="Save Note"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between mt-2">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea id="note_textarea_1" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                                    <p id="note_display_1" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="timeline_details">
                                        <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                            <div class="list-group w-100">
                                                <div class="d-flex w-100 fw-bold text-dark">
                                                    <p class="ficon m-0 lh1_3 w-100 text-start">
                                                        <small class="text-muted fw-normal fs-11">12:02:46 PM</small>
                                                        <span class="mb-1 d-block fs-14">TransactionID</span>
                                                        <small class="w-100 text-start">Details...</small>
                                                    </p>
                                                    <div class="d-flex align-items-end flex-column justify-content-between">
                                                        <p class="ficon mb-0 text-success">10000</p>
                                                        <div class="">
                                                            <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(8)" id="add_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note"
                                                               aria-label="Add Note"></i>
                                                            <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(8)" id="edit_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note"
                                                               aria-label="Edit Note"></i>
                                                            <i class="uil uil-comment-alt-message d-none" onclick="makevisible(8)" id="save_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note"
                                                               aria-label="Save Note"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between mt-2">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea id="note_textarea_2" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true"></textarea>
                                                    <p id="note_display_2" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para d-none"></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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
    <script>
        $(".year_links").click(function(e) {
            let year = e.target.getAttribute("href");
            $('html,body').animate({
                    scrollTop: ($(year).offset().top - 61)
                },
                'slow');
        });
    </script>
@endsection
