@extends('layouts.app')
@section('header')
<section class="wrapper py-22">
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

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-secondary" style="border-left: 6px solid #ffeb3b;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="ficon bx pb-0 mb-1 bx-group mr-25">TransactionID</p>
                            <p class="ficon pb-0 mb-1 bx px-6 bx-group mr-25">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">
                            <p class="d-flex mb-1 text-start" style="flex-direction: column;">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 justify-content-between text-start">
                                <textarea style="display: none; resize: none; width: 20rem;" id="note" class="me-1 mt-0 fs-11"></textarea>
                                     <p class="pe-1 fs-12" id="noteapp"></p>

                                <i class="uil pe-6 uil-comment-alt-plus" style="display: block" onclick="makevisible()" id="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note"></i>
                                <i class="uil pe-6 uil-comment-alt-message" style="display: none" onclick="makevisible()" id="save" data-bs-toggle="tooltip" data-bs-placement="right" title="Save"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-secondary" style="border-left: 6px solid #ffeb3b;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="ficon bx pb-0 mb-1 bx-group mr-25">TransactionID</p>
                            <p class="ficon pb-0 mb-1 bx px-6 bx-group mr-25">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">

                            <p class="d-flex mb-1 text-start" style="flex-direction: column;">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 justify-content-between text-start">
                                <textarea style="display: none; resize: none; width: 20rem;" id="note" class="me-1 rounded-1 info mt-0 fs-11"></textarea>
                                <i class="uil pe-6 uil-comment-alt-plus" style="display: block" onclick="makevisible()" id="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note"></i>
                                <i class="uil pe-6 uil-comment-alt-message" style="display: none" onclick="makevisible()" id="save" data-bs-toggle="tooltip" data-bs-placement="right" title="Save"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-secondary" style="border-left: 6px solid #ffeb3b;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="ficon bx pb-0 mb-1 bx-group mr-25">TransactionID</p>
                            <p class="ficon pb-0 mb-1 bx px-6 bx-group mr-25">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <small>Details...</small>
                            <i class="uil px-6 uil-comment-alt-message" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add Note"></i>
                        </div>
                        <p class="d-flex mb-1 align-items-center">
                            <small class="text-muted">12/19/2021 12:02:46 PM</small>
                        </p>
                    </div>
                </div>

                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-secondary" style="border-left: 6px solid #ffeb3b;">
                    <div class="list-group w-100 mx-1">
                        <div class="d-flex w-100 justify-content-between">
                            <p class="ficon bx pb-0 mb-1 bx-group mr-25">TransactionID</p>
                            <p class="ficon pb-0 mb-1 bx px-6 bx-group mr-25">10000</p>
                        </div>
                        <div class="d-flex w-100 justify-content-between ">
                            <p class="d-flex mb-1 text-start" style="flex-direction: column;">
                                <small>Details...</small>
                                <small class="text-muted">12/19/2021 12:02:46 PM</small>
                            </p>
                            <div class="d-flex mt-0 justify-content-between text-start">
                                <textarea style="display: none; resize: none; width: 20rem;" id="note" class="me-1 rounded-1 info mt-0 fs-11"></textarea>

                                <i class="uil pe-6 uil-comment-alt-plus" style="display: block" onclick="makevisible()" id="icon" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note"></i>
                                <i class="uil pe-6 uil-comment-alt-message" style="display: none" onclick="makevisible()" id="save" data-bs-toggle="tooltip" data-bs-placement="right" title="Save"></i>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>

@endsection
