<div x-data>
    @if (App\Helpers\Functions::not_empty($report_data))
        <div class="d-flex wrapper bg-gray">
            <!-- Page Content -->

            <div id="page-content-wrapper">

                <div class="container bg-gray pt-11 px-4">
                    <div class="row mb-15">
                        <div class="col-12 my-10 text-center">
                            <h1>Credit Worthiness Analysis</h1>
                            <p>Credit Score based on the analysis of your last 24 months</p>
                        </div>
                        <div class="col-12 col-md-4 mb-md-auto mb-2 m-auto text-center text-md-start">
                            @if ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_credit_score'] == 1))
                                <p class="fs-16 mb-0 fw-bold text-dark">Credit Score: <span class="px-3 py-0 fs-18 rounded border border-{{ $report_data[10] }} text-{{ $report_data[10] }}">{{ round($report_data[8], 0) }}</span> <span
                                          class="fw-bold text-{{ $report_data[10] }}">{{ $report_data[9] }}</span></p>
                            @endif
                        </div>
                        <div class="col-12 col-md-8 text-center">
                            @if($data[0] != 'shared')<a class="float-md-end share_icon m-1 py-1 btn btn-sm btn-group-lg btn-soft-primary" wire:click.prevent="get_sharing_info({{ true }})" data-bs-toggle="modal" data-bs-target="#shareform"
                               data-toggle="tooltip" data-placement="top" title="Share"><i class="uil uil-share-alt"></i></a>@endif
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

                        @if (count($report_data[1]) > 0 && ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_income'] == 1)))
                            <div class="col-12 col-lg-6 mb-10 d-block">
                                <div class="text-center">
                                    <h1>Income</h1>
                                    <p>Categorized</p>
                                </div>
                                <div class="d-flex justify-content-center" id="Incomechart"></div>
                            </div>
                        @endif

                        @if (count($report_data[2]) > 0 && ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_expense'] == 1)))
                            <div class="col-12 col-lg-6 mb-10 d-block">
                                <div class="text-center">
                                    <h1>Expense</h1>
                                    <p>Categorized</p>
                                </div>
                                <div class="d-flex justify-content-center" id="Expensechart"></div>
                            </div>
                        @endif

                        @if (count($report_data[0]) > 0 && ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_cash_flow'] == 1)))
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
        <div class="report-box d-none" id="report">
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
                        <p class="m-0 clearfix"><span class="float-start">Name:</span> <span class="float-end fw-bold text-dark">Muhammad Shahzad</span></p>

                        @if ($company_name != '')
                            <p class="m-0 clearfix"><span class="float-start">Company:</span> <span class="float-end fw-bold text-dark">Jan 2015</span></p>
                        @endif

                        @if ($email_addr != '' && ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_email'] == 1)))
                            <p class="m-0 clearfix"><span class="float-start">Email:</span> <span class="float-end fw-bold text-dark">{{$email_addr}}</span></p>
                        @endif

                        @if ($contact_num != '' && ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_contact'] == 1)))
                            <p class="m-0 clearfix"><span class="float-start">Contact #:</span> <span class="float-end fw-bold text-dark">Jan 2015</span></p>
                        @endif

                        <p class="m-0 clearfix"><span class="float-start">Generated At:</span> <span class="float-end fw-bold text-dark" id="time_span"></span></p>
                    </div>
                    <div class="col-6">
                        @if ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_credit_score'] == 1))
                            <p class="m-0 text-end"><span class="fw-bold">Credit Score:</span> <span class="text-muted fs-20">70</span></p>
                            <p class="text-end">Good</p>
                        @endif
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
                    @if (count($report_data[1]) > 0 && ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_income'] == 1)))
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
                        </div>
                    @endif

                    @if (count($report_data[2]) > 0 && ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_expense'] == 1)))
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
                        </div>
                    @endif
                </div>

                @if (count($report_data[0]) > 0 && ($data[0] == 'self' || ($data[0] == 'shared' && $access['view_cash_flow'] == 1)))
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

    @if(App\Helpers\Functions::not_empty($report_data) && $data[0] != 'shared')
    <div wire:ignore.self class="modal fade" id="shareform">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                    <h5 class="text-start">Share Report with</h5>
                    <div class="d-flex mb-5">
                        <input wire:model="email" name="email" type="email" class="p-1 form-control" placeholder="Email">
                        <button wire:click="add_report_user" id="addUserBtn" type="button" class="btn btn-sm btn-dark border-0 rounded-pill py-0 ms-3">
                            <i class="uil p-0 uil-user-plus text-white"></i>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <input name="credit_score" wire:model.defer="credit_score" id="credit_score" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="credit_score">Can View Credit Score</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="cash_flow" wire:model.defer="cash_flow" id="cash_flow" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="cash_flow">Can View Cash Flow</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="expenses" wire:model.defer="expenses" id="expenses" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="expenses">Can View Expenses</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="income" wire:model.defer="income" id="income" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="income">Can View Income</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="email_check" wire:model.defer="email_check" id="email_check" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="email_check" for="credit_score">Can View Email</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="contact" wire:model.defer="contact" id="contact" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="contact">Can View Contact #</label>
                        </div>

                    </div>
                    @if (App\Helpers\Functions::not_empty($error))
                        <div class="text-start lh-1"><small class="text-danger">{{ $error }}</small></div>
                    @endif
                    @if (App\Helpers\Functions::not_empty($success))
                        <div class="text-start lh-1"><small class="text-success">{{ $success }}</small></div>
                    @endif
                    <p class="text-muted text-start border-bottom fs-11 mt-4">Shared with</p>
                    <div id="listuser" class="d-block">
                        @forelse ($shared_emails as $se)
                            <div class="d-flex justify-content-between rounded bg-soft-ash m-1 p-2">
                                <div class="d-flex">
                                    <img class="h-5 me-1 rounded-circle" src='https://ui-avatars.com/api/?name={{ $se['email'] }}.jpg' />
                                    <p class="m-0">{{ $se['email'] }}</p>
                                </div>
                                <a title="Remove" wire:click="remove_report_user({{ $se['id'] }},'{{ $se['type'] }}')" class="float-end text-danger ms-2" style="cursor: pointer">
                                    <i class="uil uil-minus"></i>
                                </a>
                            </div>
                        @empty
                            Report is not shared with anyone!
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('data', {
                report_loading: true,
                toggleReportLoading() {
                    this.report_loading = !this.report_loading;
                }
            })
        });



        function printReport() {
            $('#report').toggleClass('d-none');
            $('#time_span').html(new Date().toLocaleString());
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
                                    formatter: function(val, opts){
                                        return '$' + val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w){
                                        return '$' + parseFloat(w.globals.series.reduce((a, b) => a + b, 0)).toFixed(2);
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
                        // chart: {
                        //     width: 200
                        // },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart1 = new ApexCharts(document.querySelector("#Incomechart"), options1);
            chart1.render();
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
                                    formatter: function(val, opts){
                                        return '$' + val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w){
                                        return '$' + parseFloat(w.globals.series.reduce((a, b) => a + b, 0)).toFixed(2);
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
                    // formatter: function(val, opts) {
                    //     return val + " - $" + opts.w.globals.series[opts.seriesIndex]
                    // }
                },
                title: {
                    text: ''
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        // chart: {
                        //     width: 200
                        // },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart2 = new ApexCharts(document.querySelector("#Expensechart"), options2);
            chart2.render();
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

            var chart3 = new ApexCharts(document.querySelector("#cashflowchart"), options3);
            chart3.render();
        }
    </script>
@endpush
