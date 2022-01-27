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
                <h2 class="fs-35 text-uppercase text-muted text-center mb-3">List of Accounts Shared with you</h2>
            </div>
            <div class="post-category text-line">
                <a href="#" class="hover" rel="category">Bank Name</a>
            </div>
            <div class="row gx-2">
                <div class=" col-lg-3 col-md-6 col-12">
                    <div class="card p-3">
                        <div class="d-flex flex-row justify-content-center">
                            <div class="col-5 vh-10">
                                <p class="">Account Title: </p>
                                <p>Account No: </p>
                            </div>
                            <div class="col-7 vh-10">
                                <p>Muhammad Shahzad</p>
                                <p>03060104388765</p>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between flex-column flex-sm-row">
                            <div class="d-flex flex-column col-12 justify-content-between">


                                <a href="#" class="btn float-end btn-secondary btn-sm">View Transactions</a>
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
                            <h5 class="text-start ms-1"><button class="btn-primary rounded-circle mx-1"> <i class="uil uil-user-plus"></i></button> Share with people</h5>
                            <form class="text-start mb-3">
                                <div class=" d-flex">
                                    <input type="email" id="textarea" class="p-1 m-1 form-control" placeholder="Email" id="user">

                                    <button id="addUserBtn" class="btn-sm btn-primary py-0 mx-3"><i class="uil p-0 uil-user-plus text-white"></i></button>


                                </div>

                                <p class="text-muted fs-11 ms-2">Shared with</p>
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
