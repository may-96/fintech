@extends('layouts.app')
@section('css')
<style>
    .note_textarea{
        resize: none; 
        height: 28px;
    }
    .note_para, .note_textarea{
        line-height: 1.3;
    }
</style>
@endsection
@section('header')
    <section class="wrapper py-22 hero_section_bg" style="background-image: url({{asset('images/background/Wave.svg')}})">
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
                <h2 class="h1 fs-46 mb-10 text-center mb-4">Transaction Details</h2>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-success" style="border-left: 6px solid;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between fw-bold text-dark">
                            <p class="ficon mb-1">TransactionID</p>
                            <p class="ficon mb-1 text-success">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <p class="d-flex mb-1 flex-column text-start">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 text-start align-items-end">
                                <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(1)" id="add_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note" aria-label="Add Note"></i>
                                <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(1)" id="edit_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note" aria-label="Edit Note"></i>
                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(1)" id="save_note_1" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note" aria-label="Save Note"></i>
                            </div>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">
                            <div class="d-flex mt-0 w-100 text-start">
                                <textarea id="note_textarea_1" class="w-100 px-1 pt-1 fs-11 rounded note_textarea d-none" spellcheck="true"></textarea>
                                <p id="note_display_1" class="fs-12 m-0 p-1 pe-2 w-100 alert alert-info note_para d-none" ></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-danger" style="border-left: 6px solid;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between fw-bold text-dark">
                            <p class="ficon mb-1">TransactionID</p>
                            <p class="ficon mb-1 text-danger">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <p class="d-flex mb-1 flex-column text-start">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 text-start align-items-end">
                                <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(2)" id="add_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note" aria-label="Add Note"></i>
                                <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(2)" id="edit_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note" aria-label="Edit Note"></i>
                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(2)" id="save_note_2" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note" aria-label="Save Note"></i>
                            </div>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">
                            <div class="d-flex mt-0 w-100 text-start">
                                <textarea id="note_textarea_2" class="w-100 px-1 pt-1 fs-11 rounded note_textarea d-none" spellcheck="true"></textarea>
                                <p id="note_display_2" class="fs-12 m-0 p-1 pe-2 w-100 alert alert-info note_para d-none" ></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-red" style="border-left: 6px solid;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between fw-bold text-dark">
                            <p class="ficon mb-1">TransactionID</p>
                            <p class="ficon mb-1 text-danger">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <p class="d-flex mb-1 flex-column text-start">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 text-start align-items-end">
                                <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(3)" id="add_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note" aria-label="Add Note"></i>
                                <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(3)" id="edit_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note" aria-label="Edit Note"></i>
                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(3)" id="save_note_3" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note" aria-label="Save Note"></i>
                            </div>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">
                            <div class="d-flex mt-0 w-100 text-start">
                                <textarea id="note_textarea_3" class="w-100 px-1 pt-1 fs-11 rounded note_textarea d-none" spellcheck="true"></textarea>
                                <p id="note_display_3" class="fs-12 m-0 p-1 pe-2 w-100 alert alert-info note_para d-none" ></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-success" style="border-left: 6px solid;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between fw-bold text-dark">
                            <p class="ficon mb-1">TransactionID</p>
                            <p class="ficon mb-1 text-success">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <p class="d-flex mb-1 flex-column text-start">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 text-start align-items-end">
                                <i class="uil uil-comment-alt-plus d-block" onclick="makevisible(4)" id="add_note_4" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Add Note" aria-label="Add Note"></i>
                                <i class="uil uil-comment-alt-edit d-none" onclick="makevisible(4)" id="edit_note_4" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Edit Note" aria-label="Edit Note"></i>
                                <i class="uil uil-comment-alt-message d-none" onclick="makevisible(4)" id="save_note_4" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Save Note" aria-label="Save Note"></i>
                            </div>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">
                            <div class="d-flex mt-0 w-100 text-start">
                                <textarea id="note_textarea_4" class="w-100 px-1 pt-1 fs-11 rounded note_textarea d-none" spellcheck="true"></textarea>
                                <p id="note_display_4" class="fs-12 m-0 p-1 pe-2 w-100 alert alert-info note_para d-none" ></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

@endsection

@section('js')
<script src="{{asset('js/save_transactions.js')}}"></script>
@endsection
