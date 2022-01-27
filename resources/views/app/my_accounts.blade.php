@extends('layouts.app')
@section('css')
    @endsection
@section('header')
    <section class="wrapper vh-100 d-flex align-items-center">
        <div class="container pb-19 pt-md-14 pb-md-20 text-center">
            <div class="row">
                <div class="col-md-10 col-xl-8 mx-auto">
                    <div class="post-header">
                        <!--  <div class="post-category text-line">
                              <a href="#" class="hover" rel="category">Teamwork</a>
                          </div>-->
                        <!-- /.post-category -->
                        <h1 class="display-1 fs-66 mb-4">All Bank accounts, at <br> one place</h1>
                        <p class="lead fs-23 lh-sm mb-7 text-indigo animated-caption">create an account and manage all your Cash flow efficiently</p>
                        <!-- /.post-meta -->
                    </div>
                    <!-- /.post-header -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->

  @endsection

@section('content')
            <section class="wrapper p-10 mb-2 mb-sm-20">
                <div class="container">
                    <div class="col-lg-12 mb-15 align-items-center">
                        <h2 class="fs-35 text-uppercase text-muted text-center mb-3">My Bank Accounts</h2>
                    </div>
                    <div class="post-category text-line">
                        <a href="#" class="hover" rel="category">Bank Name</a>
                    </div>
                    <div class="row gx-2">
                        <div class=" col-lg-4 col-md-6 col-12">
                            <div class="card p-3">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <p class="mb-0">Muhammad Shahzad</p>
                                    <p>03060104388765</p>
                                    </div>
                                    <a id="some" class="text-black" data-bs-toggle="modal" data-bs-target="#shareform" data-toggle="tooltip" data-placement="top" title="Share"> <i class="uil fs-35 uil-users-alt"></i></a>

                                </div>
                                <div class="d-flex justify-content-between flex-column flex-sm-row">
                                    <div class="d-flex flex-column col-12 col-sm-7 justify-content-between">
                                            <p class="text-muted mb-0">type:Current</p>
                                            <p class="text-muted">Currency:USD</p>
                                    </div>
                                    <div class="d-flex flex-column float-end mb-5 col-12 col-sm-4 justify-content-end">
                                        <a href="#" class="btn float-end btn-secondary btn-sm">View</a>
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
                                    <!-- /form -->
                                </div>
                                <!--/.modal-body -->
                            </div>
                            <!--/.modal-dialog -->
                        </div>
                        <!--/.modal -->



                </div>
                <!-- /.container -->

            </section>
            <!-- /section -->


@endsection
@section('js')

    <script src="{{asset('js/my_accounts.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.10.0/js/md5.min.js"></script>
@endsection
