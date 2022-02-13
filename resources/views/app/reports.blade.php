@extends('layouts.app')
@section('css')


    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
    <link rel="stylesheet" href="{{ asset('css/print.min.css') }}">
@endsection
@section('content')
    <div class="d-flex wrapper bg-gray" >
        <!-- Page Content -->
        <div id="page-content-wrapper">

            <div class="container bg-gray pt-10 px-4">
                <div class="row g-3 mb-15">
                    <div class="col-12 mt-10 text-center">
                    <h1>Credit Worthiness Analysis</h1>
                        <p>Credit Score based on the analysis of your last 24 months</p>
                    </div>
                    <div class="col-12 text-white col-sm-4">
                        <h3 class="bold">Credit Score: <span class="text-muted fs-20">70</span> </h3>

                    </div>
                    <div class="col-12 g-1 col-sm-8">
                        <a class="float-sm-end share_icon m-1 btn btn-group-lg btn-soft-primary" data-bs-toggle="modal" data-bs-target="#shareform" data-toggle="tooltip" data-placement="top" title="Share"><i class="uil uil-share-alt"></i></a>

                        <a class="btn btn-group-lg m-1 float-sm-end btn-soft-primary" id="generate" onclick="printReport()" >Generate Certificate</a>

                    </div>
                    <hr/>

                    <div class="col-lg-3 col-sm-6 mh-100">
                        <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <h3 class="d-flex justify-content-between fs-28 text-navy"><span>10</span><i class="uil uil-atm-card fs-20 text-navy bg-white border rounded-full px-2 py-1 "></i></h3>
                                <p class="fs-16">Total Accounts</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 mh-100">
                        <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <h3 class="d-flex justify-content-between fs-28 text-red"><span>10</span><i class="uil uil-bill fs-20 text-red bg-white border rounded-full px-2 py-1"></i></h3>
                                <p class="fs-16">Delayed Bills</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 mh-100">
                        <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <h3 class="d-flex justify-content-between fs-28 text-navy"><span>1</span><i class="uil uil-briefcase fs-20 text-navy border bg-white rounded-full px-2 py-1"></i></h3>
                                <p class="fs-16">Mortgage payment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 mh-100">
                        <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <h3 class="d-flex justify-content-between fs-28 text-orange"><span>$5000</span><i class="uil uil-money-bill fs-20 text-orange bg-white border rounded-full px-2 py-1"></i></h3>
                                <p class="fs-16">Average Income</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gy-3">
                   <!-- <div class="col-12 btn-group-sm mb-13 d-inline">
                        <h3 class="fs-30 mb-3">Year</h3>
                        <button type="button" class="btn btn-secondary">2021</button>
                        <button type="button" class="btn btn-secondary">2022</button>
                        <button type="button" id="graphs" onclick="showgraph()" class=" mx-1 btn-group-sm btn-outline-primary float-end"> <i class="uil uil-chart-bar float-end"></i> </button>
                        <button type="button" id="tables" onclick="showtable()" class="btn-group-sm btn-outline-secondary float-end"> <i class="uil uil-align-justify float-end"></i> </button>

                    </div>-->



                    <div class="col-12 col-sm-6 mb-10 d-block">
                        <div class="text-center">
                            <h1>Income</h1>
                            <p>Income of last 24 months</p>
                        </div>
                        <div class="d-flex justify-content-center" id="Incomechart"></div>
                    </div>
                    <div class="col-12 col-sm-6 mb-10 d-block">
                        <div class="text-center">
                        <h1>Expense</h1>
                        <p>Expenses of last 24 months</p>
                        </div>
                        <div class="d-flex justify-content-center" id="Expensechart"></div>
                    </div>



                    <div id="tabular" class="col">
                        <div class="col-12 text-center mb-10">
                            <h1>Monthly Flow Of Cash</h1>
                            <p>Cash Flow of last 24 months</p>
                        </div>
                        <div id="graphical" class="container col-12 mb-10">


                            <div class="col-12" id="cashflowchart">
                            </div>
                        </div>
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead class="bg-navy text-white">
                            <tr>
                                <th scope="col">Month</th>
                                <th scope="col">Cash In</th>
                                <th scope="col">Cash Out</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>January</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>February</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>March</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>April</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>May</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>June</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>July</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>August</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>September</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>October</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>November</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            <tr>
                                <td>December</td>
                                <td class="text-green">100$</td>
                                <td class="text-danger">$1200</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- /#page-content-wrapper -->
    </div>
    <div class="modal fade" id="shareform">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                    <h5 class="text-start">Share Account with</h5>
                    <div class="d-flex mb-5">
                        <input name="email" type="email" id="textarea" class="p-1 form-control" placeholder="Email">
                        <button onclick="add_shared_user" id="addUserBtn" type="button" class="btn btn-sm btn-dark border-0 rounded-pill py-0 ms-3">
                            <i class="uil p-0 uil-user-plus text-white"></i>
                        </button>
                    </div>
                    <div class="form-check">
                        <input name="share_notes" type="checkbox" class="p-1 mb-2 form-check-input">
                        <label class="form-check-label mb-2 text-start">Share  with Transaction Notes</label>

                        <input name="share_notes" type="checkbox" class="p-1 mb-2 form-check-input">
                        <label class="form-check-label mb-2  text-start">Share along with Transaction Notes</label>

                        <input name="share_notes" type="checkbox" class="p-1 mb-2 form-check-input">
                        <label class="form-check-label mb-2  text-start">Share along with Transaction Notes</label>
                        <input name="share_notes" type="checkbox" class="p-1 mb-2 form-check-input">
                        <label class="form-check-label mb-2  text-start">Share along with Transaction Notes</label>
                    </div>
                   <div class="text-start"><small class="text-danger"><p>error</p></div>
                   <div class="text-start"><small class="text-success"><p>error</p></div>
                    <p class="text-muted text-start border-bottom fs-11 mt-4">Shared with</p>
                    <div id="listuser" class="d-block">

                            <div class="d-flex justify-content-between rounded bg-soft-ash m-1 p-2">
                                <div class="d-flex">
                                    <img class="h-5 me-1 rounded-circle" src=''/>
                                    <p class="m-0">email</p>
                                </div>
                                <a title="Remove" onclick="" class="float-end text-danger ms-2" style="cursor: pointer">
                                    <i class="uil uil-minus"></i>
                                </a>
                            </div>

                            Account is not shared with anyone!


                    </div>
                </div>
            </div>
        </div>
    </div>



   <!-- print report -->


    <div class="report-box d-none" id="report">
        <div class="row g-3">
            <div class="col-2 mb-10">
                <img height="100px" src="{{asset('images/logo.png')}}">
            </div>
            <div class="col-10 mb-10 text-center">
                <h1>Nujanas Open Banking</h1>
                <p class="text-muted">
                    this is the company header add your content here.
                </p>
            </div>
            <div class="col-6 mb-15">
                <h1 class="bold">Credit Score: <span class="text-muted fs-20">70</span> </h1>

            </div>
            <div class="col-6 mb-15">
                <h5 class="bold">Full Name: Muhammad Shahzad</h5>
                <h5 class="bold">Created: <span>Jan 2015</span></h5>

            </div>
            <table class="table bg-white rounded shadow-sm  table-hover">
                <thead class="bg-gray text-black">
                <tr>
                    <th scope="col">Month</th>
                    <th scope="col" class="text-center">Cash In</th>
                    <th scope="col" class="text-center">Cash Out</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>January</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>February</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                <tr>
                    <td>March</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>April</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>May</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>June</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>August</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>September</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>October</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>November</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                <tr>
                    <td>December</td>
                    <td class="text-muted text-center">100$</td>
                    <td class="text-muted text-center">$1200</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('js/apexcharts.min.js')}}"></script>
    <script src="{{asset('js/reports.js')}}"></script>
    <script src="{{asset('js/print.min.js')}}"></script>

    <script>


        function printReport(){
            $('#report').toggleClass('d-none');
            printJS({
                printable: 'report',
                type: 'html',
                scanStyles: false,
                css: ['{{ asset('css/style.css') }}',
                    '{{ asset('css/plugins.css') }}',
                    '{{ asset('css/reports.css') }}'],
                documentTitle: 'Report',
            });
            $('#report').toggleClass('d-none');
        }

        function closeTab() {
            window.close();
        }
    </script>
@endsection

