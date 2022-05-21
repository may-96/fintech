<div x-data>
    @if (App\Helpers\Functions::not_empty($report_data))
        <div class="d-flex wrapper bg-gray">
            <!-- Page Content -->

            <div id="page-content-wrapper">

                <div class="container bg-gray pt-11 px-4">
                    <div class="row mb-15">
                        <div class="col-12 my-10 text-center">
                            <h1>Credit Worthiness Analysis</h1>
                            <p>Analysis based on your last 24 months transactions</p>
                        </div>
                        <div class="col-12 col-md-4 mb-md-auto mb-2 m-auto text-center text-md-start">
                            
                                <p class="fs-16 mb-0 fw-bold text-dark">Credit Score: <span class="px-3 py-0 fs-18 rounded border border-{{ $report_data[10] }} text-{{ $report_data[10] }}">{{ round($report_data[8], 0) }}</span> <span
                                          class="fw-bold text-{{ $report_data[10] }}">{{ $report_data[9] }}</span></p>
                            
                        </div>
                        <div class="col-12 col-md-8 text-center">
                            <a class="float-md-end m-1 py-1 btn btn-sm btn-group-lg btn-soft-primary" id="generate" onclick="printReport()">Generate PDF Report</a>
                        </div>

                        <hr />

                        <div class="col-lg-4 col-sm-6 mh-100">
                            <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div class="col-12">
                                    <h3 class="d-flex justify-content-between fs-28 text-navy"><span>{{ $report_data[7] }}</span><i class="uil uil-atm-card fs-20 text-navy bg-white border rounded-full px-2 py-1 "></i></h3>
                                    <p class="fs-14">Total Accounts</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mh-100">
                            <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div class="col-12">
                                    <h3 class="d-flex justify-content-between fs-28 text-red"><span>{{ config('app.settings.report_currency_symbol') . round($report_data[5], 2) }}</span><i
                                           class="uil uil-bill fs-20 text-red bg-white border rounded-full px-2 py-1"></i></h3>
                                    <p class="fs-14">Average Monthly Income</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 mh-100">
                            <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div class="col-12">
                                    <h3 class="d-flex justify-content-between fs-28 text-navy"><span>{{ config('app.settings.report_currency_symbol') . round($report_data[6], 2) }}</span><i
                                           class="uil uil-briefcase fs-20 text-navy border bg-white rounded-full px-2 py-1"></i></h3>
                                    <p class="fs-14">Average Monthly Expense</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3 col-sm-6 mh-100">
                                <div class="p-3 bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                                    <div class="col-12">
                                        <h3 class="d-flex justify-content-between fs-28 text-orange"><span>$5000</span><i class="uil uil-money-bill fs-20 text-orange bg-white border rounded-full px-2 py-1"></i></h3>
                                        <p class="fs-14">Average Income</p>
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                    <div class="row gy-3">

                        @if (count($report_data[1]) > 0)
                            <div class="col-12 col-lg-6 mb-10 d-block">
                                <div class="text-center">
                                    <h1>Income</h1>
                                    <p>Categorized</p>
                                </div>
                                <div class="d-flex justify-content-center" id="Incomechart"></div>
                            </div>
                        @endif

                        @if (count($report_data[2]) > 0 )
                            <div class="col-12 col-lg-6 mb-10 d-block">
                                <div class="text-center">
                                    <h1>Expense</h1>
                                    <p>Categorized</p>
                                </div>
                                <div class="d-flex justify-content-center" id="Expensechart"></div>
                            </div>
                        @endif

                        @if (count($report_data[0]) > 0 )
                            <div id="tabular" class="mb-10">
                                <div class="col-12 text-center mb-10">
                                    <h1>Monthly Flow Of Cash</h1>
                                    <p></p>
                                </div>
                                <div id="graphical" class="col-12 mb-10">
                                    <div class="col-12" id="cashflowchart">
                                    </div>
                                </div>
                                <table class="table bg-white rounded shadow-sm table-hover cash-flow-table">
                                    <thead class="bg-navy text-white">
                                        <tr>
                                            <th scope="col">Month</th>
                                            <th scope="col">Cash In</th>
                                            <th scope="col">Cash Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report_data[0] as $month => $value)
                                            <tr>
                                                <td>{{ $month }}</td>
                                                <td class="text-green">{{ config('app.settings.report_currency_symbol') . round($value[1], 2) }}</td>
                                                <td class="text-danger">{{ config('app.settings.report_currency_symbol') . round($value[3], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="fw-bold">Total</td>
                                            <td class="fw-bold text-green">{{ round($report_data[3], 2) }}</td>
                                            <td class="fw-bold text-danger">{{ round($report_data[4], 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>

        <!-- print report -->
        <div class="report-box" id="report">
            <div class="row g-3">
                <div class="col-2 m-auto">
                    <img height="100px" src="{{ asset('images/logo.png') }}">
                </div>
                <div class="col-10 m-auto">
                    <h2 class="m-0">Nujanas Open Banking</h2>
                    <p class="text-muted m-0">
                        this is the company header add your content here.
                    </p>
                </div>
                <div class="row my-10">
                    <div class="col-6">
                        @if (App\Helpers\Functions::not_empty($report_user_name))
                            <p class="m-0 clearfix"><span class="float-start">Name:</span> <span class="float-end fw-bold text-dark">{{ $report_user_name }}</span></p>
                        @endif

                        @if (App\Helpers\Functions::not_empty($company_name))
                            <p class="m-0 clearfix"><span class="float-start">Company:</span> <span class="float-end fw-bold text-dark">{{ $company_name }}</span></p>
                        @endif

                        @if (App\Helpers\Functions::not_empty($email_addr))
                            <p class="m-0 clearfix"><span class="float-start">Email:</span> <span class="float-end fw-bold text-dark">{{ $email_addr }}</span></p>
                        @endif

                        @if (App\Helpers\Functions::not_empty($contact_num))
                            <p class="m-0 clearfix"><span class="float-start">Contact #:</span> <span class="float-end fw-bold text-dark">{{ $contact_num }}</span></p>
                        @endif

                        <p class="m-0 clearfix"><span class="float-start">Generated At:</span> <span class="float-end fw-bold text-dark" id="time_span"></span></p>
                    </div>
                    <div class="col-6">
                        
                            <p class="m-0 text-end"><span class="fw-bold">Credit Score:</span> <span class="text-muted fs-20">{{ round($report_data[8], 0) }}</span></p>
                            <p class="text-end fw-bold text-{{ $report_data[10] }}">{{ $report_data[9] }}</p>
                        
                        @if ($report_data[11] > 0)
                            <p class="m-0 text-end"><span class="">Saving per Month:</span> <span>{{ config('app.settings.report_currency_symbol') . round($report_data[11], 2) }}</span></p>
                        @elseif($report_data[11] < 0)
                            <p class="m-0 text-end"><span class="">Over Spent per Month:</span> <span>{{ config('app.settings.report_currency_symbol') . round($report_data[11], 2) }}</span></p>
                        @else
                            <p class="m-0 text-end"><span class="">No Saving neither Over Spent</span></p>
                        @endif
                    </div>
                </div>

                <div class="row mb-10">
                    @if (count($report_data[1]) > 0)
                        <div class="col-6">
                            <h5>Income</h5>
                            <table class="table table-striped m-0">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th scope="col" class="py-1">Type</th>
                                        <th scope="col" class="text-center py-1">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report_data[1] as $category => $value)
                                        <tr>
                                            <td class="ps-3 text-capitalize">{{ $category }}</td>
                                            <td class="text-dark">
                                                <p class="m-0"><span>{{ config('app.settings.report_currency_symbol') . round($value[1], 2) }}</span><span class="ms-1 fw-bold fs-13">(Total)</span></p>
                                                <p class="m-0"><span>{{ config('app.settings.report_currency_symbol') . round($value[2], 2) }}</span><span class="ms-1 fw-bold fs-13">(Average)</span></p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="w-100">
                                <div class="d-flex justify-content-center align-items-center w-100" id="IncomechartPrint"></div>
                            </div>
                        </div>
                    @endif

                    @if (count($report_data[2]) > 0)
                        <div class="col-6">
                            <h5>Expense</h5>
                            <table class="table table-striped m-0">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th scope="col" class="py-1">Type</th>
                                        <th scope="col" class="text-center py-1">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report_data[2] as $category => $value)
                                        <tr>
                                            <td class="ps-3">{{ $category }}</td>
                                            <td class="text-dark">
                                                <p class="m-0"><span>{{ config('app.settings.report_currency_symbol') . round($value[1], 2) }}</span><span class="ms-1 fw-bold fs-13">(Total)</span></p>
                                                <p class="m-0"><span>{{ config('app.settings.report_currency_symbol') . round($value[2], 2) }}</span><span class="ms-1 fw-bold fs-13">(Average)</span></p>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="w-100">
                                <div class="d-flex justify-content-center align-items-center w-100" id="ExpensechartPrint"></div>
                            </div>
                        </div>
                    @endif
                </div>

                @if (count($report_data[0]) > 0)
                    <div class="row">
                        <div class="col-12">
                            <h5>Cash Flow</h5>
                            <table class="table table-striped m-0">
                                <thead class="bg-secondary text-white">
                                    <tr>
                                        <th scope="col" class="py-1">Month</th>
                                        <th scope="col" class="text-center py-1">Cash In</th>
                                        <th scope="col" class="text-center py-1">Cash Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report_data[0] as $month => $value)
                                        <tr>
                                            <td class="ps-3">{{ $month }}</td>
                                            <td class="text-dark text-center">{{ config('app.settings.report_currency_symbol') . round($value[1], 2) }}</td>
                                            <td class="text-dark text-center">{{ config('app.settings.report_currency_symbol') . round($value[3], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="ps-3 fw-bold">Total</td>
                                        <td class="text-dark text-center fw-bold">{{ config('app.settings.report_currency_symbol') . round($report_data[3], 2) }}</td>
                                        <td class="text-dark text-center fw-bold">{{ config('app.settings.report_currency_symbol') . round($report_data[4], 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="p-6 w-100">
                                <div class="d-flex justify-content-center align-items-center w-100" id="cashflowchartprint"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <template x-if="$store.data.report_loading">
        <div id="loading_bars" class="d-flex vh-100 align-items-center justify-content-center">
            <x-loading />
            Generating Report! Please wait patiently ...
        </div>
    </template>
    
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('data', {
                report_loading: true,
                toggleReportLoading() {
                    this.report_loading = !this.report_loading;
                    setTimeout(() => {
                        $('#report').toggleClass('d-none');
                    }, 1000)
                    
                }
            })
        });



        function printReport() {
            
            $('#report').toggleClass('d-none');
            
            $('#time_span').html(new Date().toLocaleString());
            setTimeout(() => {
                printJS({
                    printable: 'report',
                    type: 'html',
                    scanStyles: false,
                    css: ['{{ asset('css/style.css') }}',
                        '{{ asset('css/plugins.css') }}',
                        '{{ asset('css/reports.css') }}'
                    ],
                    documentTitle: 'Report',
                });
                $('#report').toggleClass('d-none');
            }, 1500)

        }

        window.livewire.on('reportLoaded', (graphData) => {
            Alpine.store('data').toggleReportLoading();
            setTimeout(() => {
                if (@this.cash_flow_data_available) {
                    generate_cash_flow_graph(graphData.cash_flow);
                }
                if (@this.income_data_available) {
                    generate_income_graph(graphData.income);
                }
                if (@this.expense_data_available) {
                    generate_expense_graph(graphData.expense);
                }

            }, 500);

        });

        $(document).ready(function() {
            @this.load_report();
        });

        function generate_income_graph(gdata) {
            let data = [];

            let cats = Object.keys(gdata);
            let cat_data = Object.entries(gdata);

            cat_data.forEach((cat, index) => {
                data.push(parseFloat(parseFloat(cat[1][1]).toFixed(2)));
            });

            var options1 = {
                series: data,
                labels: cats,
                chart: {
                    width: 450,
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                },
                                value: {
                                    formatter: function(val, opts) {
                                        return '$' +
                                            val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w) {
                                        return '$' +
                                            parseFloat(w.globals.series.reduce((a, b) => a + b, 0)).toFixed(2);
                                    }
                                }
                            },

                        }
                    }
                },
                dataLabels: {
                    enabled: true
                },
                fill: {
                    type: 'gradient',
                },
                legend: {
                    position: 'right',
                },
                title: {
                    text: ''
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            var options1p = {
                series: data,
                labels: cats,
                chart: {
                    width: 400,
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                },
                                value: {
                                    formatter: function(val, opts) {
                                        return '$' +
                                            val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w) {
                                        return '$' +
                                            parseFloat(w.globals.series.reduce((a, b) => a + b, 0)).toFixed(2);
                                    }
                                }
                            },

                        }
                    }
                },
                dataLabels: {
                    enabled: true
                },
                fill: {
                    type: 'gradient',
                },
                legend: {
                    position: 'bottom',
                },
                title: {
                    text: ''
                },
                responsive: [{
                    breakpoint: 400,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart1 = new ApexCharts(document.querySelector("#Incomechart"), options1);
            var chart1p = new ApexCharts(document.querySelector("#IncomechartPrint"), options1p);
            chart1.render();
            chart1p.render();
        }

        function generate_expense_graph(gdata) {
            let data = [];

            let cats = Object.keys(gdata);
            let cat_data = Object.entries(gdata);

            cat_data.forEach((cat, index) => {
                data.push(parseFloat(parseFloat(cat[1][1]).toFixed(2)));
            });

            var options2 = {
                series: data,
                labels: cats,
                chart: {
                    width: 450,
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                },
                                value: {
                                    formatter: function(val, opts) {
                                        return '$' +
                                            val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w) {
                                        return '$' +
                                            parseFloat(w.globals.series.reduce((a, b) => a + b, 0)).toFixed(2);
                                    }
                                }
                            },

                        }
                    }
                },
                dataLabels: {
                    enabled: true
                },
                fill: {
                    type: 'gradient',
                },
                legend: {
                    position: 'right',
                },
                title: {
                    text: ''
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            var options2p = {
                series: data,
                labels: cats,
                chart: {
                    width: 400,
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                },
                                value: {
                                    formatter: function(val, opts) {
                                        return '$' +
                                            val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w) {
                                        return '$' +
                                            parseFloat(w.globals.series.reduce((a, b) => a + b, 0)).toFixed(2);
                                    }
                                }
                            },

                        }
                    }
                },
                dataLabels: {
                    enabled: true
                },
                fill: {
                    type: 'gradient',
                },
                legend: {
                    position: 'bottom',
                },
                title: {
                    text: ''
                },
                responsive: [{
                    breakpoint: 400,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart2 = new ApexCharts(document.querySelector("#Expensechart"), options2);
            var chart2p = new ApexCharts(document.querySelector("#ExpensechartPrint"), options2p);
            chart2.render();
            chart2p.render();
        }

        function generate_cash_flow_graph(gdata) {
            let cin = [];
            let cout = [];

            let cats = Object.keys(gdata);
            let cat_data = Object.entries(gdata);

            cat_data.forEach((cat, index) => {
                cin.push(parseFloat(parseFloat(cat[1][1]).toFixed(2)));
                cout.push(parseFloat(parseFloat(cat[1][3]).toFixed(2)));
            });

            var options3 = {
                series: [{
                    name: 'Cash In',
                    data: cin
                }, {
                    name: 'Cash Out',
                    data: cout
                }],
                colors: ['#6bbea3', '#e2626b'],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '80%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['#6bbea3', '#e2626b'],
                },
                xaxis: {
                    categories: cats,
                },
                yaxis: {
                    title: {
                        text: 'Amount ($)'
                    }
                },
                fill: {
                    opacity: 1,
                    colors: ['#6bbea3', '#e2626b'],
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "$" + val
                        }
                    }
                }
            };
            var options3p = {
                series: [{
                    name: 'Cash In',
                    data: cin
                }, {
                    name: 'Cash Out',
                    data: cout
                }],
                colors: ['#6bbea3', '#e2626b'],
                chart: {
                    type: 'bar',
                    width: 500,
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '80%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['#6bbea3', '#e2626b'],
                },
                xaxis: {
                    categories: cats,
                },
                yaxis: {
                    title: {
                        text: 'Amount ($)'
                    }
                },
                fill: {
                    opacity: 1,
                    colors: ['#6bbea3', '#e2626b'],
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "$" + val
                        }
                    }
                }
            };

            var chart3 = new ApexCharts(document.querySelector("#cashflowchart"), options3);
            var chart3p = new ApexCharts(document.querySelector("#cashflowchartprint"), options3p);
            chart3.render();
            chart3p.render();
        }
    </script>
@endpush
