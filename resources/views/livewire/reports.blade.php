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
                            @if ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_credit_score'] == 1))
                                {{-- <p class="fs-16 mb-0 fw-bold text-dark">Cash Flow Score: <span class="px-3 py-0 fs-18 rounded border border-{{ $report_data[10] }} text-{{ $report_data[10] }}">{{ round($report_data[8], 0) }}</span> 
                                    <span class="fw-bold text-{{ $report_data[10] }}">{{ $report_data[9] }}</span>
                                </p> --}}
                                @if($report_data[18] > 0)<p class="fs-16 mb-0 fw-bold text-dark">Credit Score: <span class="px-3 py-0 fs-18 rounded border border-{{ $report_data[20] }} text-{{ $report_data[20] }}">{{ round($report_data[18] , 1) }}</span> 
                                <span class="fw-bold text-{{ $report_data[20] }}">{{ $report_data[19] }}</span>

                                </p>@endif
                            @endif
                        </div>
                        <div class="col-12 col-md-8 text-center">
                            @if ($data[0] != 'shared' && $data[0] != 'link_shared' && $data[0] != 'link_shared_everyone')
                                <a class="float-md-end share_icon m-1 py-1 btn btn-sm btn-group-lg btn-soft-primary" wire:click.prevent="get_sharing_info({{ true }})" data-bs-toggle="modal" data-bs-target="#shareform"
                                   data-toggle="tooltip" data-placement="top" title="Share"><i class="uil uil-share-alt"></i></a>
                            @endif
                            <a class="float-md-end m-1 py-1 btn btn-sm btn-group-lg btn-soft-primary" id="generate" data-bs-toggle="modal" data-bs-target="#printform">Generate PDF Report</a>
                        </div>

                        <hr />

                        @if (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $amount_check != null && $amount_check > 0 )
                        <div class="col-12 mb-3 mh-100">
                            <div class="p-3 bg-soft-green border shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div class="col-12">
                                    <p>
                                        Affordability for the purpose of this screening is calculated based on the formula <strong>[ 2.5 * Amount Under Consideration ]</strong>, Amount Under Consideration is <strong>{{$currency}} {{round($amount_check,2)}}</strong>.<br>Based on the bank account transactions you submitted your average gross income is <strong>{{$currency}} {{ round(($report_data[5]  * (float)$report_data[17]), 2) }}</strong> per month.<br>Your affordable monthly expenses would be based on this formula be <strong>{{$currency}} {{ round((((float)$report_data[5] * (float)$report_data[17])/2.5), 2) }}</strong>.<br>The expected expense for the purpose of this screening are <strong>{{$currency}} {{round((2.5 * $amount_check),2)}}</strong>.<br>
                                    {{-- Average Gross Income * Exchange > 2.5 * Amount to Loan --}}
                                    @if( ((float)$report_data[5] * (float)$report_data[17]) > (2.5 * $amount_check) )
                                    Therefore we except you <strong class="text-green simple_underline">will be able to afford</strong> the expenses for the which the screening is intended for
                                    {{-- <p class="fs-14 m-0">After analyzing the account(s) of this user we find the user <strong class="text-green">WORTHY</strong> enough to loan the amount / rent the house of amount <strong>{{$currency}} {{round($amount_check,2)}}</strong></p> --}}
                                    @else
                                    Therefore we except you <strong class="text-red simple_underline">won’t be able to afford</strong> the expenses for the which the screening is intended for
                                    {{-- <p class="fs-14 m-0">After analyzing the account(s) of this user we find the user <strong class="text-red">NOT WORTHY</strong> enough to loan the amount / rent the house of amount <strong>{{$currency}} {{round($amount_check,2)}}</strong></p> --}}
                                    @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-lg-4 col-sm-6 mh-100">
                            <div class="p-3 border bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div class="col-12">
                                    <h3 class="d-flex justify-content-between fs-28 text-navy"><span>{{ $report_data[7] }}</span><i class="uil uil-atm-card fs-20 text-navy bg-white border rounded-full px-2 py-1 "></i></h3>
                                    <p class="fs-14">Total Accounts</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mh-100">
                            <div class="p-3 border bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div class="col-12">
                                    <h3 class="d-flex justify-content-between fs-28 text-success"><span>{{ $report_data[16] . ' ' . round($report_data[5], 2) }}</span><i
                                           class="uil uil-bill fs-20 text-success bg-white border rounded-full px-2 py-1"></i></h3>
                                    <p class="fs-14">Average Monthly Income</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 mh-100">
                            <div class="p-3 border bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                                <div class="col-12">
                                    <h3 class="d-flex justify-content-between fs-28 text-navy"><span>{{ $report_data[16] . ' ' . round($report_data[6], 2) }}</span><i
                                           class="uil uil-briefcase fs-20 text-navy border bg-white rounded-full px-2 py-1"></i></h3>
                                    <p class="fs-14">Average Monthly Expense</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3 col-sm-6 mh-100">
                                <div class="p-3 border bg-gradient-dark shadow-lg d-flex justify-content-around align-items-center rounded">
                                    <div class="col-12">
                                        <h3 class="d-flex justify-content-between fs-28 text-orange"><span>$5000</span><i class="uil uil-money-bill fs-20 text-orange bg-white border rounded-full px-2 py-1"></i></h3>
                                        <p class="fs-14">Average Income</p>
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                    <div class="row gy-3">

                        @if (count($report_data[1]) > 0 && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_income'] == 1)))
                            <div class="col-12 col-lg-6 mb-10 d-block">
                                <div class="text-center">
                                    <h1>Income</h1>
                                    <p>Categorized</p>
                                </div>
                                <div class="d-flex justify-content-center" id="Incomechart"></div>
                            </div>
                        @endif

                        @if (count($report_data[2]) > 0 && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_expense'] == 1)))
                            <div class="col-12 col-lg-6 mb-10 d-block">
                                <div class="text-center">
                                    <h1>Expense</h1>
                                    <p>Categorized</p>
                                </div>
                                <div class="d-flex justify-content-center" id="Expensechart"></div>
                            </div>
                        @endif

                        <div class="row mb-10">
                            @if (count($report_data[14]) > 0)
                                <div class="col-12 mb-10 table-responsive">
                                    <h5>Incoming Consistent Payments</h5>
                                    <h6>More than 6 months consistent payments</h6>
                                    <table class="table m-0 mb-10 consistency">
                                        @php $title_printed = false; @endphp
                                        <thead class="bg-aqua text-white">
                                            <tr>
                                                <th scope="col" class="py-1"></th>
                                                <th scope="col" class="text-center py-1">Streak</th>
                                                <th scope="col" class="text-center py-1">Transaction Count</th>
                                                <th scope="col" class="text-center py-1">Total Amount</th>
                                                <th scope="col" class="text-center py-1">No. of Months</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $streak_found = false; @endphp
                                            @foreach ($report_data[14] as $title => $value)
                                                @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                                @foreach($value[4] as $index => $streak)
                                                    @if($streak[0] > 6)
                                                        @php $streak_found = true; @endphp
                                                        
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                        <tr class="account_title">
                                                            <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                        </tr>
                                                        @endif
                                                        @php $streak_count += 1; @endphp
                                                        <tr class="streak_details">
                                                            <td colspan="1"></td>
                                                            <td class="text-center">{{$streak_count}}</td>
                                                            <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                            <td class="text-center text-capitalize">
                                                                <div>{{ $report_data[16] . ' ' . round($streak[1],2) }}</div>
                                                                <div><small>(Avg. Monthly Amount: {{ $report_data[16] . ' ' . round(($streak[1]/$streak[0]),2) }})</small></div>
                                                            </td>
                                                            <td class="text-center text-capitalize">
                                                                <div>{{ $streak[0] }}</div>
                                                                <div>
                                                                    @php
                                                                        $start_date = Carbon\Carbon::parse($streak[2]['fixed_date']);
                                                                        $end_date = Carbon\Carbon::parse($streak[count($streak) - 1]['fixed_date']);
                                                                    @endphp
                                                                    <small>{{$start_date->format('M') .', '. $start_date->year . ' - ' . $end_date->format('M') .', '. $end_date->year }}</small>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" class="bg-white">
                                                            @foreach ($streak as $streak_index => $val)
                                                                @if($streak_index > 1)
                                                                    @php $transaction_date = Carbon\Carbon::parse($val['fixed_date']); @endphp
                                                                    <div class="d-flex justify-content-between border-bottom p-1">
                                                                        <span>{{$transaction_date->day . ' ' . $transaction_date->format('M') .', '. $transaction_date->year}}</span>
                                                                        <span><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;word-break: break-word; overflow-wrap: break-word; line-break: anywhere;" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($val['remit_info_unstructured'])){!! nl2br($val['remit_info_unstructured']) !!} @else {!! nl2br($val['remittance_information_structured']) !!} @endif</pre></span>
                                                                        <span>{{$report_data[16] . ' ' . abs(round($val['transaction_amount'],2))}}</span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            @if(!$streak_found)
                                                <tr>
                                                    <td colspan="5">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <h6>3 to 6 months consistent payments</h6>
                                    <table class="table m-0 mb-10 consistency">
                                        @php $title_printed = false; @endphp
                                        <thead class="bg-aqua text-white">
                                            <tr>
                                                <th scope="col" class="py-1"></th>
                                                <th scope="col" class="text-center py-1">Streak</th>
                                                <th scope="col" class="text-center py-1">Transaction Count</th>
                                                <th scope="col" class="text-center py-1">Total Amount</th>
                                                <th scope="col" class="text-center py-1">No. of Months</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $streak_found = false; @endphp
                                            @foreach ($report_data[14] as $title => $value)
                                                @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                                @foreach($value[4] as $index => $streak)
                                                    @if($streak[0] >= 3 && $streak[0] <= 6)
                                                        @php $streak_found = true; @endphp
                                                        
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                        <tr class="account_title">
                                                            <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                        </tr>
                                                        @endif
                                                        @php $streak_count += 1; @endphp
                                                        <tr class="streak_details">
                                                            <td colspan="1"></td>
                                                            <td class="text-center">{{$streak_count}}</td>
                                                            <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                            <td class="text-center text-capitalize">
                                                                <div>{{ $report_data[16] . ' ' . round($streak[1],2) }}</div>
                                                                <div><small>(Avg. Monthly Amount: {{ $report_data[16] . ' ' . round(($streak[1]/$streak[0]),2) }})</small></div>
                                                            </td>
                                                            <td class="text-center text-capitalize">
                                                                <div>{{ $streak[0] }}</div>
                                                                <div>
                                                                    @php
                                                                        $start_date = Carbon\Carbon::parse($streak[2]['fixed_date']);
                                                                        $end_date = Carbon\Carbon::parse($streak[count($streak) - 1]['fixed_date']);
                                                                    @endphp
                                                                    <small>{{$start_date->format('M') .', '. $start_date->year . ' - ' . $end_date->format('M') .', '. $end_date->year }}</small>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" class="bg-white">
                                                            @foreach ($streak as $streak_index => $val)
                                                                @if($streak_index > 1)
                                                                    @php $transaction_date = Carbon\Carbon::parse($val['fixed_date']); @endphp
                                                                    <div class="d-flex justify-content-between border-bottom p-1">
                                                                        <span>{{$transaction_date->day . ' ' . $transaction_date->format('M') .', '. $transaction_date->year}}</span>
                                                                        <span><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;word-break: break-word; overflow-wrap: break-word; line-break: anywhere;" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($val['remit_info_unstructured'])){!! nl2br($val['remit_info_unstructured']) !!} @else {!! nl2br($val['remittance_information_structured']) !!} @endif</pre></span>
                                                                        <span>{{$report_data[16] . ' ' . abs(round($val['transaction_amount'],2))}}</span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            @if(!$streak_found)
                                                <tr>
                                                    <td colspan="5">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    {{-- <h6>Less than 3 months consistent payments</h6>
                                    <table class="table m-0 mb-10 consistency">
                                        @php $title_printed = false; @endphp
                                        <thead class="bg-aqua text-white">
                                            <tr>
                                                <th scope="col" class="py-1"></th>
                                                <th scope="col" class="text-center py-1">Streak</th>
                                                <th scope="col" class="text-center py-1">Transaction Count</th>
                                                <th scope="col" class="text-center py-1">Total Amount</th>
                                                <th scope="col" class="text-center py-1">No. of Months</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $streak_found = false; @endphp
                                            @foreach ($report_data[14] as $title => $value)
                                                @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                                @foreach($value[4] as $index => $streak)
                                                    @if($streak[0] < 3)
                                                        @php $streak_found = true; @endphp
                                                        
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                        <tr class="account_title">
                                                            <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                        </tr>
                                                        @endif
                                                        @php $streak_count += 1; @endphp
                                                        <tr class="streak_details">
                                                            <td colspan="1"></td>
                                                            <td class="text-center">{{$streak_count}}</td>
                                                            <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                            <td class="text-center text-capitalize">{{ $report_data[16] . ' ' . round($streak[1],2) }}</td>
                                                            <td class="text-center text-capitalize">{{ $streak[0] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            @if(!$streak_found)
                                                <tr>
                                                    <td colspan="5">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table> --}}
                                </div>
                            @endif
                            @if (count($report_data[15]) > 0)
                                <div class="col-12 mb-10 table-responsive">
                                    <h5>Outgoing Consistency</h5>
                                    <h6>More than 6 months consistent payments</h6>
                                    <table class="table m-0 mb-10 consistency">
                                        @php $title_printed = false; @endphp
                                        <thead class="bg-aqua text-white">
                                            <tr>
                                                <th scope="col" class="py-1"></th>
                                                <th scope="col" class="text-center py-1">Streak</th>
                                                <th scope="col" class="text-center py-1">Transaction Count</th>
                                                <th scope="col" class="text-center py-1">Total Amount</th>
                                                <th scope="col" class="text-center py-1">No. of Months</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $streak_found = false; @endphp
                                            @foreach ($report_data[15] as $title => $value)
                                                @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                                @foreach($value[4] as $index => $streak)
                                                    @if($streak[0] > 6)
                                                        @php $streak_found = true; @endphp
                                                        
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                        <tr class="account_title">
                                                            <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                        </tr>
                                                        @endif
                                                        @php $streak_count += 1; @endphp
                                                        <tr class="streak_details">
                                                            <td colspan="1"></td>
                                                            <td class="text-center">{{$streak_count}}</td>
                                                            <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                            <td class="text-center text-capitalize">
                                                                <div>{{ $report_data[16] . ' ' . round($streak[1],2) }}</div>
                                                                <div><small>(Avg. Monthly Amount: {{ $report_data[16] . ' ' . round(($streak[1]/$streak[0]),2) }})</small></div>
                                                            </td>
                                                            <td class="text-center text-capitalize">
                                                                <div>{{ $streak[0] }}</div>
                                                                <div>
                                                                    @php
                                                                        $start_date = Carbon\Carbon::parse($streak[2]['fixed_date']);
                                                                        $end_date = Carbon\Carbon::parse($streak[count($streak) - 1]['fixed_date']);
                                                                    @endphp
                                                                    <small>{{$start_date->format('M') .', '. $start_date->year . ' - ' . $end_date->format('M') .', '. $end_date->year }}</small>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" class="bg-white">
                                                            @foreach ($streak as $streak_index => $val)
                                                                @if($streak_index > 1)
                                                                    @php $transaction_date = Carbon\Carbon::parse($val['fixed_date']); @endphp
                                                                    <div class="d-flex justify-content-between border-bottom p-1">
                                                                        <span>{{$transaction_date->day . ' ' . $transaction_date->format('M') .', '. $transaction_date->year}}</span>
                                                                        <span><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;word-break: break-word; overflow-wrap: break-word; line-break: anywhere;" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($val['remit_info_unstructured'])){!! nl2br($val['remit_info_unstructured']) !!} @else {!! nl2br($val['remittance_information_structured']) !!} @endif</pre></span>
                                                                        <span>{{$report_data[16] . ' ' . abs(round($val['transaction_amount'],2))}}</span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                
                                            @endforeach
                                            @if(!$streak_found)
                                                <tr>
                                                    <td colspan="5">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <h6>3 to 6 months consistent payments</h6>
                                    <table class="table m-0 mb-10 consistency">
                                        @php $title_printed = false; @endphp
                                        <thead class="bg-aqua text-white">
                                            <tr>
                                                <th scope="col" class="py-1"></th>
                                                <th scope="col" class="text-center py-1">Streak</th>
                                                <th scope="col" class="text-center py-1">Transaction Count</th>
                                                <th scope="col" class="text-center py-1">Total Amount</th>
                                                <th scope="col" class="text-center py-1">No. of Months</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $streak_found = false; @endphp
                                            @foreach ($report_data[15] as $title => $value)
                                                @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                                @foreach($value[4] as $index => $streak)
                                                    @if($streak[0] >= 3 && $streak[0] <= 6)
                                                        @php $streak_found = true; @endphp
                                                        
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                        <tr class="account_title">
                                                            <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                        </tr>
                                                        @endif
                                                        @php $streak_count += 1; @endphp
                                                        <tr class="streak_details">
                                                            <td colspan="1"></td>
                                                            <td class="text-center">{{$streak_count}}</td>
                                                            <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                            <td class="text-center text-capitalize">
                                                                <div>{{ $report_data[16] . ' ' . round($streak[1],2) }}</div>
                                                                <div><small>(Avg. Monthly Amount: {{ $report_data[16] . ' ' . round(($streak[1]/$streak[0]),2) }})</small></div>
                                                            </td>
                                                            <td class="text-center text-capitalize">
                                                                <div>{{ $streak[0] }}</div>
                                                                <div>
                                                                    @php
                                                                        $start_date = Carbon\Carbon::parse($streak[2]['fixed_date']);
                                                                        $end_date = Carbon\Carbon::parse($streak[count($streak) - 1]['fixed_date']);
                                                                    @endphp
                                                                    <small>{{$start_date->format('M') .', '. $start_date->year . ' - ' . $end_date->format('M') .', '. $end_date->year }}</small>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" class="bg-white">
                                                            @foreach ($streak as $streak_index => $val)
                                                                @if($streak_index > 1)
                                                                    @php $transaction_date = Carbon\Carbon::parse($val['fixed_date']); @endphp
                                                                    <div class="d-flex justify-content-between border-bottom p-1">
                                                                        <span>{{$transaction_date->day . ' ' . $transaction_date->format('M') .', '. $transaction_date->year}}</span>
                                                                        <span><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;word-break: break-word; overflow-wrap: break-word; line-break: anywhere;" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($val['remit_info_unstructured'])){!! nl2br($val['remit_info_unstructured']) !!} @else {!! nl2br($val['remittance_information_structured']) !!} @endif</pre></span>
                                                                        <span>{{$report_data[16] . ' ' . abs(round($val['transaction_amount'],2))}}</span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                
                                            @endforeach
                                            @if(!$streak_found)
                                                <tr>
                                                    <td colspan="5">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    {{-- <h6>Less than 3 months consistent payments</h6>
                                    <table class="table m-0 mb-10 consistency">
                                        @php $title_printed = false;
                                        <thead class="bg-aqua @endphp text-white">
                                            <tr>
                                                <th scope="col" class="py-1"></th>
                                                <th scope="col" class="text-center py-1">Streak</th>
                                                <th scope="col" class="text-center py-1">Transaction Count</th>
                                                <th scope="col" class="text-center py-1">Total Amount</th>
                                                <th scope="col" class="text-center py-1">No. of Months</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $streak_found = false; @endphp
                                            @foreach ($report_data[15] as $title => $value)
                                                @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                                @foreach($value[4] as $index => $streak)
                                                    @if($streak[0] < 3)
                                                        @php $streak_found = true; @endphp
                                                        
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                        <tr class="account_title">
                                                            <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                        </tr>
                                                        @endif
                                                        @php $streak_count += 1; @endphp
                                                        <tr class="streak_details">
                                                            <td colspan="1"></td>
                                                            <td class="text-center">{{$streak_count}}</td>
                                                            <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                            <td class="text-center text-capitalize">{{ $report_data[16] . ' ' . round($streak[1],2) }}</td>
                                                            <td class="text-center text-capitalize">{{ $streak[0] }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            @if(!$streak_found)
                                                <tr>
                                                    <td colspan="5">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table> --}}
                                </div>
                            @endif
                        </div>

                        @if (count($report_data[0]) > 0 && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared'|| $data[0] == 'link_shared_everyone') && $access['view_cash_flow'] == 1)))
                            <div id="tabular" class="mb-10">
                                <div class="col-12 text-center mb-10">
                                    <h1>Monthly Flow Of Cash</h1>
                                    <p></p>
                                </div>
                                <div id="graphical" class="col-12 mb-10">
                                    <div class="col-12" id="cashflowchart"></div>
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
                                                <td class="text-green">{{ $report_data[16] . ' ' . round($value[1], 2) }}</td>
                                                <td class="text-danger">{{ $report_data[16] . ' ' . round($value[3], 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th class="fw-bold">Total</th>
                                            <th class="fw-bold text-green">{{ $report_data[16] . ' ' . round($report_data[3], 2) }}</th>
                                            <th class="fw-bold text-danger">{{ $report_data[16] . ' ' . round($report_data[4], 2) }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>

        <!-- print report -->
        <div class="report-box mb-15" id="report">
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
                        @if (App\Helpers\Functions::not_empty($report_user_name) && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_initials_only'] == 0)))
                            <p class="m-0 clearfix"><span class="float-start">Name:</span> <span class="float-end fw-bold text-dark">{{ $report_user_name }}</span></p>
                        @elseif(App\Helpers\Functions::not_empty($report_user_name) && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_initials_only'] == 1)))
                            <p class="m-0 clearfix"><span class="float-start">Name Initials:</span> <span class="float-end fw-bold text-dark">{{ $report_user_name_initials }}</span></p>
                        @endif

                        @if (App\Helpers\Functions::not_empty($company_name))
                            <p class="m-0 clearfix"><span class="float-start">Company:</span> <span class="float-end fw-bold text-dark">{{ $company_name }}</span></p>
                        @endif

                        @if (App\Helpers\Functions::not_empty($email_addr) && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_email'] == 1)))
                            <p class="m-0 clearfix"><span class="float-start">Email:</span> <span class="float-end fw-bold text-dark">{{ $email_addr }}</span></p>
                        @endif

                        @if (App\Helpers\Functions::not_empty($contact_num) && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_contact'] == 1)))
                            <p class="m-0 clearfix"><span class="float-start">Contact #:</span> <span class="float-end fw-bold text-dark">{{ $contact_num }}</span></p>
                        @endif

                        <p class="m-0 clearfix"><span class="float-start">Generated At:</span> <span class="float-end fw-bold text-dark" id="time_span"></span></p>
                    </div>
                    <div class="col-6">
                        @if ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_credit_score'] == 1))
                            <p class="m-0 text-end"><span class="fw-bold">Cash Flow Score:</span> <span class="text-muted fs-20">{{ round($report_data[8], 0) }}</span></p>
                            <p class="text-end fw-bold text-{{ $report_data[10] }}">{{ $report_data[9] }}</p>
                            @if($report_data[18] > 0)<p class="m-0 text-end"><span class="fw-bold">Credit Score:</span> <span class="text-muted fs-20">{{ round($report_data[18], 1) }}</span></p>
                            <p class="text-end fw-bold text-{{ $report_data[20] }}">{{ $report_data[19] }}</p>@endif
                        @endif
                        @if ($report_data[11] > 0)
                            <p class="m-0 text-end"><span class="">Saving per Month:</span> <span>{{ $report_data[16] . ' ' . round($report_data[11], 2) }}</span></p>
                        @elseif($report_data[11] < 0)
                            <p class="m-0 text-end"><span class="">Over Spent per Month:</span> <span>{{ $report_data[16] . ' ' . round($report_data[11], 2) }}</span></p>
                        @else
                            <p class="m-0 text-end"><span class="">No Saving neither Over Spent</span></p>
                        @endif
                        <p class="m-0 text-end"><span class="fw-bold">Monthly Salary:</span> <span>{{ $report_data[16] . ' ' . round($report_data[12], 2) }}</span></p>
                        <p class="m-0 text-end"><span class="fw-bold">Accounts Anaylzed:</span> <span>{{ $report_data[7] }}</span></p>
                        <p class="m-0 text-end"><span class="fw-bold">Account Names</span></p>
                        @foreach ($account_names as $account_name)
                            <p class="m-0 text-end"> <span>{{ $account_name }}</span></p>
                        @endforeach
                    </div>
                </div>
                <div class="row mb-5">
                    @if (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $amount_check != null && $amount_check > 0)
                    <div class="col-12 mh-100">
                        <div class="p-3 bg-soft-green border shadow-lg d-flex justify-content-around align-items-center rounded">
                            <div class="col-12">
                                <p>
                                    Affordability for the purpose of this screening is calculated based on the formula <strong>[ 2.5 * Amount Under Consideration ]</strong>, Amount Under Consideration is <strong>{{$currency}} {{round($amount_check,2)}}</strong>.<br>Based on the bank account transactions you submitted your average gross income is <strong>{{$currency}} {{ round(($report_data[5]  * (float)$report_data[17]), 2) }}</strong> per month.<br>Your affordable monthly expenses would be based on this formula be <strong>{{$currency}} {{ round((((float)$report_data[5] * (float)$report_data[17])/2.5), 2) }}</strong>.<br>The expected expense for the purpose of this screening are <strong>{{$currency}} {{round((2.5 * $amount_check),2)}}</strong>.<br>
                                {{-- Average Gross Income * Exchange > 2.5 * Amount to Loan --}}
                                @if( ((float)$report_data[5] * (float)$report_data[17]) > (2.5 * $amount_check) )
                                Therefore we except you <strong class="text-green simple_underline">will be able to afford</strong> the expenses for the which the screening is intended for
                                {{-- <p class="fs-14 m-0">After analyzing the account(s) of this user we find the user <strong class="text-green">WORTHY</strong> enough to loan the amount / rent the house of amount <strong>{{$currency}} {{round($amount_check,2)}}</strong></p> --}}
                                @else
                                Therefore we except you <strong class="text-red simple_underline">won’t be able to afford</strong> the expenses for the which the screening is intended for
                                {{-- <p class="fs-14 m-0">After analyzing the account(s) of this user we find the user <strong class="text-red">NOT WORTHY</strong> enough to loan the amount / rent the house of amount <strong>{{$currency}} {{round($amount_check,2)}}</strong></p> --}}
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row mb-10">
                    @if (count($report_data[1]) > 0 && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_income'] == 1)))
                        <div class="col-12 mb-10">
                            <h5>Income</h5>
                            <table class="table table-striped m-0 mb-10">
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
                                                <p class="m-0"><span>{{ $report_data[16] . ' ' . round($value[1], 2) }}</span><span class="ms-1 fw-bold fs-13">(Total)</span></p>
                                                <p class="m-0"><span>{{ $report_data[16] . ' ' . round($value[2], 2) }}</span><span class="ms-1 fw-bold fs-13">(Average)</span></p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="w-100 mb-20 graphical_area">
                                <div class="d-flex justify-content-center align-items-center w-100" id="IncomechartPrint"></div>
                            </div>
                        </div>
                    @endif

                    @if (count($report_data[2]) > 0 && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_expense'] == 1)))
                        <div class="col-12 mb-10">
                            <h5>Expense</h5>
                            <table class="table table-striped m-0 mb-10">
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
                                                <p class="m-0"><span>{{ $report_data[16] . ' ' . round($value[1], 2) }}</span><span class="ms-1 fw-bold fs-13">(Total)</span></p>
                                                <p class="m-0"><span>{{ $report_data[16] . ' ' . round($value[2], 2) }}</span><span class="ms-1 fw-bold fs-13">(Average)</span></p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="w-100 mb-20 graphical_area">
                                <div class="d-flex justify-content-center align-items-center w-100" id="ExpensechartPrint"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row mb-10">
                    @if (count($report_data[14]) > 0)
                        <div class="col-12 mb-10 table-responsive">
                            <h5>Incoming Consistent Payments</h5>
                            <h6>More than 6 months consistent payments</h6>
                            <table class="table m-0 mb-10 consistency">
                                @php $title_printed = false; @endphp 
                                <thead class="bg-aqua text-white">
                                    <tr>
                                        <th scope="col" class="py-1"></th>
                                        <th scope="col" class="text-center py-1">Streak</th>
                                        <th scope="col" class="text-center py-1">Transaction Count</th>
                                        <th scope="col" class="text-center py-1">Total Amount</th>
                                        <th scope="col" class="text-center py-1">No. of Months</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $streak_found = false; @endphp
                                    @foreach ($report_data[14] as $title => $value)
                                        @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                        @foreach($value[4] as $index => $streak)
                                            @if($streak[0] > 6)
                                                @php $streak_found = true; @endphp
                                                
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                <tr class="account_title">
                                                    <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                </tr>
                                                @endif
                                                @php $streak_count += 1; @endphp
                                                <tr class="streak_details">
                                                    <td colspan="1"></td>
                                                    <td class="text-center">{{$streak_count}}</td>
                                                    <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                    <td class="text-center text-capitalize">
                                                        <div>{{ $report_data[16] . ' ' . round($streak[1],2) }}</div>
                                                        <div><small>(Avg. Monthly Amount: {{ $report_data[16] . ' ' . round(($streak[1]/$streak[0]),2) }})</small></div>
                                                    </td>
                                                    <td class="text-center text-capitalize">
                                                        <div>{{ $streak[0] }}</div>
                                                        <div>
                                                            @php
                                                                $start_date = Carbon\Carbon::parse($streak[2]['fixed_date']);
                                                                $end_date = Carbon\Carbon::parse($streak[count($streak) - 1]['fixed_date']);
                                                            @endphp
                                                            <small>{{$start_date->format('M') .', '. $start_date->year . ' - ' . $end_date->format('M') .', '. $end_date->year }}</small>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="bg-white">
                                                    @foreach ($streak as $streak_index => $val)
                                                        @if($streak_index > 1)
                                                            @php $transaction_date = Carbon\Carbon::parse($val['fixed_date']); @endphp
                                                            <div class="d-flex justify-content-between border-bottom p-1">
                                                                <span>{{$transaction_date->day . ' ' . $transaction_date->format('M') .', '. $transaction_date->year}}</span>
                                                                <span><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;word-break: break-word; overflow-wrap: break-word; line-break: anywhere; overflow: visible;" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($val['remit_info_unstructured'])){!! nl2br($val['remit_info_unstructured']) !!} @else {!! nl2br($val['remittance_information_structured']) !!} @endif</pre></span>
                                                                <span>{{$report_data[16] . ' ' . abs(round($val['transaction_amount'],2))}}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @if(!$streak_found)
                                        <tr>
                                            <td colspan="5">No data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <h6>3 to 6 months consistent payments</h6>
                            <table class="table m-0 mb-10 consistency">
                                @php $title_printed = false; @endphp
                                <thead class="bg-aqua text-white">
                                    <tr>
                                        <th scope="col" class="py-1"></th>
                                        <th scope="col" class="text-center py-1">Streak</th>
                                        <th scope="col" class="text-center py-1">Transaction Count</th>
                                        <th scope="col" class="text-center py-1">Total Amount</th>
                                        <th scope="col" class="text-center py-1">No. of Months</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $streak_found = false; @endphp
                                    @foreach ($report_data[14] as $title => $value)
                                        @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                        @foreach($value[4] as $index => $streak)
                                            @if($streak[0] >= 3 && $streak[0] <= 6)
                                                @php $streak_found = true; @endphp
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                <tr class="account_title">
                                                    <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                </tr>
                                                @endif
                                                @php $streak_count += 1; @endphp
                                                <tr class="streak_details">
                                                    <td colspan="1"></td>
                                                    <td class="text-center">{{$streak_count}}</td>
                                                    <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                    <td class="text-center text-capitalize">
                                                        <div>{{ $report_data[16] . ' ' . round($streak[1],2) }}</div>
                                                        <div><small>(Avg. Monthly Amount: {{ $report_data[16] . ' ' . round(($streak[1]/$streak[0]),2) }})</small></div>
                                                    </td>
                                                    <td class="text-center text-capitalize">
                                                        <div>{{ $streak[0] }}</div>
                                                        <div>
                                                            @php
                                                                $start_date = Carbon\Carbon::parse($streak[2]['fixed_date']);
                                                                $end_date = Carbon\Carbon::parse($streak[count($streak) - 1]['fixed_date']);
                                                            @endphp
                                                            <small>{{$start_date->format('M') .', '. $start_date->year . ' - ' . $end_date->format('M') .', '. $end_date->year }}</small>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="bg-white">
                                                    @foreach ($streak as $streak_index => $val)
                                                        @if($streak_index > 1)
                                                            @php $transaction_date = Carbon\Carbon::parse($val['fixed_date']); @endphp
                                                            <div class="d-flex justify-content-between border-bottom p-1">
                                                                <span>{{$transaction_date->day . ' ' . $transaction_date->format('M') .', '. $transaction_date->year}}</span>
                                                                <span><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;word-break: break-word; overflow-wrap: break-word; line-break: anywhere; overflow: visible;" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($val['remit_info_unstructured'])){!! nl2br($val['remit_info_unstructured']) !!} @else {!! nl2br($val['remittance_information_structured']) !!} @endif</pre></span>
                                                                <span>{{$report_data[16] . ' ' . abs(round($val['transaction_amount'],2))}}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @if(!$streak_found)
                                        <tr>
                                            <td colspan="5">No data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{-- <h6>Less than 3 months consistent payments</h6>
                            <table class="table m-0 mb-10 consistency">
                                @php $title_printed = false; @endphp 
                                <thead class="bg-aqua text-white">
                                    <tr>
                                        <th scope="col" class="py-1"></th>
                                        <th scope="col" class="text-center py-1">Streak</th>
                                        <th scope="col" class="text-center py-1">Transaction Count</th>
                                        <th scope="col" class="text-center py-1">Total Amount</th>
                                        <th scope="col" class="text-center py-1">No. of Months</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $streak_found = false; @endphp
                                    @foreach ($report_data[14] as $title => $value)
                                        @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                        @foreach($value[4] as $index => $streak)
                                            @if($streak[0] < 3)
                                                @php $streak_found = true; @endphp
                                                
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                <tr class="account_title">
                                                    <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                </tr>
                                                @endif
                                                @php $streak_count += 1; @endphp
                                                <tr class="streak_details">
                                                    <td colspan="1"></td>
                                                    <td class="text-center">{{$streak_count}}</td>
                                                    <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                    <td class="text-center text-capitalize">{{ $report_data[16] . ' ' . round($streak[1],2) }}</td>
                                                    <td class="text-center text-capitalize">{{ $streak[0] }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @if(!$streak_found)
                                        <tr>
                                            <td colspan="5">No data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table> --}}
                        </div>
                    @endif
                    @if (count($report_data[15]) > 0)
                        <div class="col-12 mb-10 table-responsive">
                            <h5>Outgoing Consistency</h5>
                            <h6>More than 6 months consistent payments</h6>
                            <table class="table m-0 mb-10 consistency">
                                @php $title_printed = false; @endphp 
                                <thead class="bg-aqua text-white">
                                    <tr>
                                        <th scope="col" class="py-1"></th>
                                        <th scope="col" class="text-center py-1">Streak</th>
                                        <th scope="col" class="text-center py-1">Transaction Count</th>
                                        <th scope="col" class="text-center py-1">Total Amount</th>
                                        <th scope="col" class="text-center py-1">No. of Months</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $streak_found = false; @endphp
                                    @foreach ($report_data[15] as $title => $value)
                                        @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                        @foreach($value[4] as $index => $streak)
                                            @if($streak[0] > 6)
                                                @php $streak_found = true; @endphp
                                                
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                <tr class="account_title">
                                                    <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                </tr>
                                                @endif
                                                @php $streak_count += 1; @endphp
                                                <tr class="streak_details">
                                                    <td colspan="1"></td>
                                                    <td class="text-center">{{$streak_count}}</td>
                                                    <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                    <td class="text-center text-capitalize">
                                                        <div>{{ $report_data[16] . ' ' . round($streak[1],2) }}</div>
                                                        <div><small>(Avg. Monthly Amount: {{ $report_data[16] . ' ' . round(($streak[1]/$streak[0]),2) }})</small></div>
                                                    </td>
                                                    <td class="text-center text-capitalize">
                                                        <div>{{ $streak[0] }}</div>
                                                        <div>
                                                            @php
                                                                $start_date = Carbon\Carbon::parse($streak[2]['fixed_date']);
                                                                $end_date = Carbon\Carbon::parse($streak[count($streak) - 1]['fixed_date']);
                                                            @endphp
                                                            <small>{{$start_date->format('M') .', '. $start_date->year . ' - ' . $end_date->format('M') .', '. $end_date->year }}</small>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="bg-white">
                                                    @foreach ($streak as $streak_index => $val)
                                                        @if($streak_index > 1)
                                                            @php $transaction_date = Carbon\Carbon::parse($val['fixed_date']); @endphp
                                                            <div class="d-flex justify-content-between border-bottom p-1">
                                                                <span>{{$transaction_date->day . ' ' . $transaction_date->format('M') .', '. $transaction_date->year}}</span>
                                                                <span><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;word-break: break-word; overflow-wrap: break-word; line-break: anywhere; overflow: visible;" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($val['remit_info_unstructured'])){!! nl2br($val['remit_info_unstructured']) !!} @else {!! nl2br($val['remittance_information_structured']) !!} @endif</pre></span>
                                                                <span>{{$report_data[16] . ' ' . abs(round($val['transaction_amount'],2))}}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        
                                    @endforeach
                                    @if(!$streak_found)
                                        <tr>
                                            <td colspan="5">No data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <h6>3 to 6 months consistent payments</h6>
                            <table class="table m-0 mb-10 consistency">
                                @php $title_printed = false; @endphp
                                <thead class="bg-aqua text-white">
                                    <tr>
                                        <th scope="col" class="py-1"></th>
                                        <th scope="col" class="text-center py-1">Streak</th>
                                        <th scope="col" class="text-center py-1">Transaction Count</th>
                                        <th scope="col" class="text-center py-1">Total Amount</th>
                                        <th scope="col" class="text-center py-1">No. of Months</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $streak_found = false; @endphp
                                    @foreach ($report_data[15] as $title => $value)
                                        @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                        @foreach($value[4] as $index => $streak)
                                            @if($streak[0] >= 3 && $streak[0] <= 6)
                                                @php $streak_found = true; @endphp
                                                
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                <tr class="account_title">
                                                    <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                </tr>
                                                @endif
                                                @php $streak_count += 1; @endphp
                                                <tr class="streak_details">
                                                    <td colspan="1"></td>
                                                    <td class="text-center">{{$streak_count}}</td>
                                                    <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                    <td class="text-center text-capitalize">
                                                        <div>{{ $report_data[16] . ' ' . round($streak[1],2) }}</div>
                                                        <div><small>(Avg. Monthly Amount: {{ $report_data[16] . ' ' . round(($streak[1]/$streak[0]),2) }})</small></div>
                                                    </td>
                                                    <td class="text-center text-capitalize">
                                                        <div>{{ $streak[0] }}</div>
                                                        <div>
                                                            @php
                                                                $start_date = Carbon\Carbon::parse($streak[2]['fixed_date']);
                                                                $end_date = Carbon\Carbon::parse($streak[count($streak) - 1]['fixed_date']);
                                                            @endphp
                                                            <small>{{$start_date->format('M') .', '. $start_date->year . ' - ' . $end_date->format('M') .', '. $end_date->year }}</small>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="bg-white">
                                                    @foreach ($streak as $streak_index => $val)
                                                        @if($streak_index > 1)
                                                            @php $transaction_date = Carbon\Carbon::parse($val['fixed_date']); @endphp
                                                            <div class="d-flex justify-content-between border-bottom p-1">
                                                                <span>{{$transaction_date->day . ' ' . $transaction_date->format('M') .', '. $transaction_date->year}}</span>
                                                                <span><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;word-break: break-word; overflow-wrap: break-word; line-break: anywhere; overflow: visible;" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($val['remit_info_unstructured'])){!! nl2br($val['remit_info_unstructured']) !!} @else {!! nl2br($val['remittance_information_structured']) !!} @endif</pre></span>
                                                                <span>{{$report_data[16] . ' ' . abs(round($val['transaction_amount'],2))}}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        
                                    @endforeach
                                    @if(!$streak_found)
                                        <tr>
                                            <td colspan="5">No data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{-- <h6>Less than 3 months consistent payments</h6>
                            <table class="table m-0 mb-10 consistency">
                                @php $title_printed = false; @endphp
                                <thead class="bg-aqua text-white">
                                    <tr>
                                        <th scope="col" class="py-1"></th>
                                        <th scope="col" class="text-center py-1">Streak</th>
                                        <th scope="col" class="text-center py-1">Transaction Count</th>
                                        <th scope="col" class="text-center py-1">Total Amount</th>
                                        <th scope="col" class="text-center py-1">No. of Months</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $streak_found = false; @endphp
                                    @foreach ($report_data[15] as $title => $value)
                                        @php $streak_count = 0; @endphp
                                                @php $title_printed = false; @endphp
                                        @foreach($value[4] as $index => $streak)
                                            @if($streak[0] < 3)
                                                @php $streak_found = true; @endphp
                                                
                                                        @if(!$title_printed)
                                                        @php $title_printed = true; @endphp
                                                <tr class="account_title">
                                                    <td colspan="5" class="text-start text-capitalize fw-bold">{{ $title }}</td>
                                                </tr>
                                                @endif
                                                @php $streak_count += 1; @endphp
                                                <tr class="streak_details">
                                                    <td colspan="1"></td>
                                                    <td class="text-center">{{$streak_count}}</td>
                                                    <td class="text-center text-capitalize">{{ count($streak) - 2 }}</td>
                                                    <td class="text-center text-capitalize">{{ $report_data[16] . ' ' . round($streak[1],2) }}</td>
                                                    <td class="text-center text-capitalize">{{ $streak[0] }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @if(!$streak_found)
                                        <tr>
                                            <td colspan="5">No data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table> --}}
                        </div>
                    @endif
                </div>

                @if (count($report_data[0]) > 0 && ($data[0] == 'self' || (($data[0] == 'shared' || $data[0] == 'self_shared' || $data[0] == 'link_shared' || $data[0] == 'link_shared_everyone') && $access['view_cash_flow'] == 1)))
                    <div class="row mb-10">
                        <div class="col-12">
                            <h5>Cash Flow</h5>
                            <table class="table table-striped m-0 mb-10">
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
                                            <td class="text-dark text-center">{{ $report_data[16] . ' ' . round($value[1], 2) }}</td>
                                            <td class="text-dark text-center">{{ $report_data[16] . ' ' . round($value[3], 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="ps-3 fw-bold">Total</td>
                                        <td class="text-dark text-center fw-bold">{{ $report_data[16] . ' ' . round($report_data[3], 2) }}</td>
                                        <td class="text-dark text-center fw-bold">{{ $report_data[16] . ' ' . round($report_data[4], 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="w-100 mb-20 graphical_area">
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

    @if (App\Helpers\Functions::not_empty($report_data) && $data[0] != 'shared' && $data[0] != 'link_shared' && $data[0] != 'link_shared_everyone')
        <div wire:ignore.self class="modal fade" id="shareform">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                        <h5 class="text-start">Share Report with</h5>
                        <div class="d-flex mb-5">
                            <input wire:model.defer="email" name="email" type="email" class="p-1 form-control" placeholder="Email">
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
                                <label class="form-check-label mb-2 fs-14 text-start" for="email_check">Can View Email</label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input name="contact" wire:model.defer="contact" id="contact" type="checkbox" class="p-1 mb-2 form-check-input">
                                <label class="form-check-label mb-2 fs-14 text-start" for="contact">Can View Contact #</label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input name="initials_only" wire:model.defer="initials_only" id="initials_only" type="checkbox" class="p-1 mb-2 form-check-input">
                                <label class="form-check-label mb-2 fs-14 text-start" for="initials_only">Initials of the Name</label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input name="account_initials_only" wire:model.defer="account_initials_only" id="account_initials_only" type="checkbox" class="p-1 mb-2 form-check-input">
                                <label class="form-check-label mb-2 fs-14 text-start" for="account_initials_only">Initials of the Account Name</label>
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
                        <div>
                            <p class="text-muted text-start border-bottom fs-11 mt-4">Shareable Link</p>
                            @if (App\Helpers\Functions::is_empty($shareable_link))
                                <button wire:click="generate_shareable_link()" class="btn btn-sm btn-soft-ash rounded-pill py-0 px-2" type="button">Generate Shareable Link</button>
                            @else
                                <div class="">
                                    <p class="fs-14 alert alert-info px-2 py-1 mb-1" id="shareable_link">{{ route('get.report', $shareable_link) }}</p>
                                    <div class="d-flex justify-content-between"><a href="javascript:void(0)" onclick="copy_text()" class="btn btn-sm btn-soft-primary p-0 px-1">Copy</a> <a href="javascript:void(0)"
                                           class="btn btn-soft-red btn-sm p-0 px-1" wire:click="remove_shareable_link()" title="Remove"><i class="uil uil-trash-alt"></i></a></div>
                                    <strong id="copy_toast" class="d-none">Link Copied !</strong>
                                    <textarea style="display: none;" id="copyTextarea"></textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif

    <div wire:ignore.self class="modal fade" id="printform">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                    <h5 class="text-start">Print Report</h5>
                    
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <input x-model="$store.data.print_settings" value="graph" name="print_graph" id="print_graph" type="radio" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="print_graph">Print with Graphs</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input x-model="$store.data.print_settings" value="no_graph" name="print_no_graph" id="print_no_graph" type="radio" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="print_no_graph">Print Without Graphs</label>
                        </div>
                        <div class="col-12">
                            <button x-on:click="$store.data.reportPrint()" id="printBtn" type="button" class="btn btn-sm btn-dark border-0 rounded-pill py-0 ms-3">Print</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
    <script>
        function printReport(setting = 'graph') {
            
            $('#report').toggleClass('d-none');
            if(setting == 'no_graph'){
                $('.graphical_area').addClass('d-none');
            }
            
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
                if(setting == 'no_graph'){
                    $('.graphical_area').removeClass('d-none');
                }
            }, 1500)

        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('data', {
                report_loading: true,
                print_settings: 'no_graph',
                toggleReportLoading() {
                    this.report_loading = !this.report_loading;
                    if(this.report_loading == false){
                        setTimeout(() => {
                            $('#report').addClass('d-none');
                        }, 1000);
                    }                    
                },
                hidePrintableReport(){
                    if(! ($('#report').hasClass('d-none'))){
                        setTimeout(() => {
                            $('#report').addClass('d-none');
                        }, 1000);
                    }
                },
                reportPrint(){
                    printReport(this.print_settings);
                }
            })
        });

        

        function copy_text() {
            var copyText = document.getElementById("shareable_link").innerHTML;
            var copy = document.getElementById("copyTextarea");
            copy.value = copyText;
            copy.select();
            copy.setSelectionRange(0, 99999);
            document.execCommand("copy");
            navigator.clipboard.writeText(copyText);

            var copy_text_notify = document.getElementById('copy_toast');
            copy_text_notify.classList.toggle('d-none');
            setTimeout(() => {
                copy_text_notify.classList.toggle('d-none');
            }, 2000);
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

        window.livewire.on('hidePrintableReport', () => {
            Alpine.store('data').hidePrintableReport();
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
                                        return @this.report_data[16] + " " +
                                            val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w) {
                                        return @this.report_data[16] + " " +
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
                                        return @this.report_data[16] + " " +
                                            val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w) {
                                        return @this.report_data[16] + " " +
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
                                        return @this.report_data[16] + " " +
                                            val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w) {
                                        return @this.report_data[16] + " " +
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
                                        return @this.report_data[16] + " " +
                                            val;
                                    }
                                },
                                total: {
                                    show: true,
                                    color: 'black',
                                    formatter: function(w) {
                                        return @this.report_data[16] + " " +
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
                        text: 'Amount ' + @this.report_data[16]
                    }
                },
                fill: {
                    opacity: 1,
                    colors: ['#6bbea3', '#e2626b'],
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return @this.report_data[16] + " " + val
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
                        text: 'Amount '+ @this.report_data[16]
                    }
                },
                fill: {
                    opacity: 1,
                    colors: ['#6bbea3', '#e2626b'],
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return @this.report_data[16] + " " + val
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