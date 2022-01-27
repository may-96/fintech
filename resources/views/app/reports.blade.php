@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="d-flex wrapper bg-gray" >
        <!-- Page Content -->
        <div id="page-content-wrapper">

            <div class="container bg-gray py-10 px-4">
                <div class="row g-3 my-2">
                    <div class="col-12 mt-10 text-center">
                    <h1>Credit Worthiness Analysis</h1>
                        <p>Credit Score based on the analysis of your last 24 months</p>
                    </div>
                    <hr/>
                    <div class="col-lg-3 mh-100">
                        <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <h3 class="d-flex justify-content-between fs-28 text-navy"><span>10</span><i class="uil uil-atm-card fs-20 text-navy bg-white border rounded-full px-2 py-1 "></i></h3>
                                <p class="fs-16">Total Accounts</p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-3 mh-100">
                        <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <h3 class="d-flex justify-content-between fs-28 text-red"><span>10</span><i class="uil uil-bill fs-20 text-red bg-white border rounded-full px-2 py-1"></i></h3>
                                <p class="fs-16">Delayed Bills</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mh-100">
                        <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <h3 class="d-flex justify-content-between fs-28 text-navy"><span>1</span><i class="uil uil-briefcase fs-20 text-navy border bg-white rounded-full px-2 py-1"></i></h3>
                                <p class="fs-16">Mortgage payment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mh-100">
                        <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <h3 class="d-flex justify-content-between fs-28 text-orange"><span>$5000</span><i class="uil uil-money-bill fs-20 text-orange bg-white border rounded-full px-2 py-1"></i></h3>
                                <p class="fs-16">Average Income</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gy-3 my-5">
                    <div class="col-12 btn-group-sm mb-13 d-inline">
                        <h3 class="fs-30 mb-3">Year</h3>
                        <button type="button" class="btn btn-secondary">2021</button>
                        <button type="button" class="btn btn-secondary">2022</button>
                        <button type="button" id="graphs" onclick="showgraph()" class=" mx-1 btn-group-sm btn-outline-primary float-end"> <i class="uil uil-chart-bar float-end"></i> </button>
                        <button type="button" id="tables" onclick="showtable()" class="btn-group-sm btn-outline-secondary float-end"> <i class="uil uil-align-justify float-end"></i> </button>

                    </div>
                    <div id="graphical" class="container col-12 d-flex flex-column flex-lg-row">
                        <div class="col-12 col-lg-8" id="chart2">
                        </div>
                        <div class="col-lg-4 col-12 align-items-center" id="chart">
                        </div>
                    </div>
                    <div id="tabular" class="col d-none">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Month</th>
                                <th scope="col">Utility Bills</th>
                                <th scope="col">Mortgage</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>January</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>February</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>March</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>April</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>May</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>June</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>July</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">8</th>
                                <td>August</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">9</th>
                                <td>September</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">10</th>
                                <td>October</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">11</th>
                                <td>November</td>
                                <td>100$</td>
                                <td>$1200</td>
                            </tr>
                            <tr>
                                <th scope="row">12</th>
                                <td>December</td>
                                <td>100$</td>
                                <td>$1200</td>
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


    <script src="{{asset('js/apexcharts.min.js')}}"></script>

    <script src="{{asset('js/reports.js')}}"></script>
@endsection

