@extends('layouts.app')
@section('css')
    @endsection
@section('header')




    <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30">
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
            <section class="wrapper bg-soft-ash mb-2 mb-sm-20">
                <div class="container">
                    <div class="col-lg-12 mb-15 align-items-center">
                        <h2 class="fs-15 text-uppercase text-muted text-center mb-3">My Bank Account</h2>
                        <h3 class="display-4 text-center">List of all the linked Accounts.</h3>
                    </div>
                <div class="post-category text-line">
                    <a href="#" class="hover" rel="category">Bank Name</a>
                </div>
            <!-- /.post-header -->
            <div class="d-flex flex-column flex-lg-row">

                <div class="d-flex card flex-row col-lg-3 col-sm-10 col-11 mx-2">
                    <div class="d-flex ps-4 pt-1 h-100 col-6 flex-column">

                        <p class="mb-0">Account Title</p>
                        <p>Account Number</p>



                    </div>
                    <div class="d-flex p-2 justify-content-between col-6 flex-column">

                        <a href="#" class="btn btn-outline-green btn-sm">open</a>

                    </div>

                </div>

            </div>
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->

@endsection
@section('js')

@endsection
