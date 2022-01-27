@extends('layouts.app')

@section('css')
@endsection

@section('header')
    <section class="wrapper vh-100 d-flex align-items-center hero-section-bg" style="background-image: url({{ asset('images/background/Animated_Shape.svg') }})">
        <div class="container pb-19 pt-md-14 pb-md-20 text-center">
            <div class="row">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="post-header">
                        <h1 class="display-1 mb-3">Account Shared with You</h1>
                        <p>One place to manage all the shared accounts</p>
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
                <h2 class="display-4 mb-3 text-center">Shared Accounts</h2>
                <p class="lead fs-lg mb-10 text-center px-md-16 px-lg-21 px-xl-0">Here is the list of the Bank Accounts that are shared with you.</p>
            </div>

            <div class="post-category text-line">
                <a href="#" class="hover" rel="category">User Name</a>
            </div>

            <div class="row gy-4">
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="card p-3 w-100">
                        <div>
                            <div class="d-flex text-primary align-items-center justify-content-between fs-16 fw-bold lh-1 mb-2">
                                <span>Nick Name</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between fs-14 lh-1 mb-0">
                                <span>GL11SAFI05510125815</span><span>
                                    <a class="share_icon fs-18" title="Add Title"><i class="uil uil-edit"></i></a>
                                </span>
                            </div>
                            <p class="mb-0 fs-14 text-warning">John Doe</p>
                        </div>
                        <div>
                            <div class="clearfix">
                                <small class="text-muted">Currency: <span class="text-dark">EUR</span></small>
                            </div>
                            <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center mt-2">
                                <a class="btn small btn-sm btn-soft-ash rounded-pill px-4 py-0 float-end" href="#">View Transactions</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

@endsection
