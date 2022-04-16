<section>
    <div x-data class="content-wrapper ">
        <section class="wrapper text-center">
            <div class="container">
                <div class="row p-3">
                    <div class="col-12 rounded bg-pale-navy py-4">
                        <div>{{ $institution->name }}</div>
                        <div class="fw-bold text-dark fs-18">{{ $account->iban }}</div>
                        @if(App\Helpers\Functions::not_empty($account->currency))
                        <div>
                            Currency: <strong>{{ $account->currency }}</strong>
                        </div>
                        @endif
                        <div>
                            @if(App\Helpers\Functions::not_empty($account->account_name)) {{ $account->account_name }} @endif @if(App\Helpers\Functions::not_empty($account->account_name) && App\Helpers\Functions::not_empty($account->owner_name)) - @endif @if(App\Helpers\Functions::not_empty($account->owner_name)) {{ $account->owner_name }} @endif
                        </div>
                        <div>
                            <button class="btn btn-circle btn-soft-yellow" title="Share" data-bs-toggle="modal" data-bs-target="#shareform"><i class="uil uil-share-alt"></i></button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
            <div class="container pt-6 pb-19 pt-md-10 pb-md-20 text-center">

                @if (!empty($balances)) 
                    <div class="row mb-6 gy-4 justify-content-center">
                        @foreach ($balances as $balance)
                            @if ($balance['type'] == 'expected')
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    <div class="card card bg-soft-blue border-blue big_border_bottom">
                                        <div class="card-body text-start px-4 py-2">
                                            <h5 class="card-title">{{ $balance['currency'] }} {{ $balance['amount'] }}</h5>
                                            <p class="card-text fs-14">Expected Balance</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($balance['type'] == 'closingBooked')
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    <div class="card card bg-soft-yellow border-yellow big_border_bottom">
                                        <div class="card-body text-start px-4 py-2">
                                            <h5 class="card-title">{{ $balance['currency'] }} {{ $balance['amount'] }}</h5>
                                            <p class="card-text fs-14">Closing Balance</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- <h2 class="h1 fs-46 text-center">Transactions</h2> --}}
                <div class="d-inline-block text-center mb-10">
                    <button title="Timeline View 1" x-bind:class="$store.data.view == 'timeline' ? 'btn-soft-primary' : 'btn-soft-ash' " class="btn btn-circle" type="button" x-on:click="$store.data.change_view('timeline')"><i
                        class="uil uil-calendar-alt"></i></button>
                    <button title="Timeline View 2" x-bind:class="$store.data.view == 'timeline2' ? 'btn-soft-primary' : 'btn-soft-ash' " class="btn btn-circle" type="button" x-on:click="$store.data.change_view('timeline2')"><i
                        class="uil uil-chart-bar-alt"></i></button>
                    {{-- <button title="List View" x-bind:class="$store.data.view == 'list' ? 'btn-soft-primary' : 'btn-soft-ash' " class="btn btn-circle" type="button" x-on:click="$store.data.change_view('list')"><i
                           class="uil uil-list-ul"></i></button> --}}
                    
                </div>

                {{-- <template x-if="$store.data.view == 'list'">

                    @if ($transaction_status == 'OK')
                        <div id="transactions_area">
                            @forelse($transactions as $transaction)
                                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-navy big_border_left">
                                    <div class="list-group w-100 mx-1">
                                        <div class="d-flex w-100 justify-content-between fw-bold text-dark pointer" x-on:click="$store.data.toggleTransaction('list',{{ $transaction->id }})">
                                            <p class="ficon mb-0 me-2" ><span>{{ $transaction->custom_uid }}</span> <span><i id="transaction_list_icon_{{ $transaction->id }}" class="uil uil-arrow-down v-middle text-muted"></i></span></p>
                                            <p class="ficon @if((float)$transaction['transaction_amount'] > 0) text-primary @else text-danger @endif mb-0">{{ $transaction->transaction_currency }} {{ $transaction->transaction_amount }}</p>
                                        </div>
                                        <div x-bind:class="$store.data.is_expanded({{ $transaction->id }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="d-flex w-100 justify-content-between transaction_list_{{ $transaction->id }}">
                                            <div class="dropdown">
                                                <button class="btn border-primary text-primary border-1 btn-sm dropdown-toggle fs-12 py-0 px-2" id="list_view_category_toggle_{{ $transaction->id }}" type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    @if (App\Helpers\Functions::is_empty($transaction->category_id))
                                                    Uncategorized @else {{ $transaction->category->name }} <small
                                                               class="ms-2 fs-11 text-capitalize @if ($transaction->category->type == 'income') text-green @else text-red @endif">{{ $transaction->category->type }}</small>
                                                    @endif
                                                </button>
                                                <ul class="dropdown-menu border shadow-lg lh-1 px-0 py-1" aria-labelledby="list_view_category_toggle_{{ $transaction->id }}"
                                                    style="height: 280px; min-width: 230px; overflow-y: auto; overflow-x: hidden;">
                                                    <li class="dropdown-list-item d-flex align-items-center justify-content-between">
                                                        <span x-on:click="$store.data.change_category({{ $transaction->id }},null)"
                                                              class="dropdown-item fs-12 lh-1 px-3 py-1 @if (App\Helpers\Functions::is_empty($transaction->category_id)) active @endif">Uncategorized</span>
                                                    </li>
                                                    @foreach ($categories as $category)
                                                        @if (((float) $transaction->transaction_amount < 0 && $category['type'] == 'expense') || ((float) $transaction->transaction_amount >= 0 && $category['type'] == 'income'))
                                                            <li class="dropdown-list-item d-flex align-items-center justify-content-between">
                                                                <span x-on:click="$store.data.change_category({{ $transaction->id }}, {{ $category['id'] }})"
                                                                      class="dropdown-item fs-12 lh-1 px-3 py-2 @if ($category['id'] == $transaction->category_id) active @endif">{{ $category['name'] }}</span>
                                                                <small class="text-capitalize badge @if ($category['type'] == 'income') bg-green @else bg-red @endif rounded-pill py-1">{{ $category['type'] }}</small>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>

                                                <div id="cat_update_loader_{{ $transaction->id }}" class="d-none">
                                                    <x-loading />
                                                </div>

                                            </div>
                                        </div>
                                        <div x-bind:class="$store.data.is_expanded({{ $transaction->id }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="d-flex w-100 justify-content-between transaction_list_{{ $transaction->id }}">
                                            <p class="d-flex mb-1 flex-column text-start">
                                                <small>{{ $transaction->remit_info_unstructured }}</small>
                                                <small class="text-muted">{{ Carbon\Carbon::parse($transaction->fixed_date)->format('d F, Y') }}</small>
                                            </p>
                                            <div class="d-flex mt-0 text-start align-items-end">
                                                <i x-on:click="$store.data.noteTrigger({{ $transaction['id'] }},'add')" class="uil uil-comment-alt-plus comment_btn @if (App\Helpers\Functions::is_empty($transaction->notes)) d-block @else d-none @endif"
                                                   onclick="makevisible({{ $transaction->id }})" id="add_note_{{ $transaction->id }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note"
                                                   data-bs-original-title="Add Note" aria-label="Add Note"></i>
                                                <i x-on:click="$store.data.noteTrigger({{ $transaction['id'] }},'edit')" class="uil uil-comment-alt-edit comment_btn @if (App\Helpers\Functions::is_empty($transaction->notes)) d-none @else d-block @endif"
                                                   onclick="makevisible({{ $transaction->id }})" id="edit_note_{{ $transaction->id }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Edit Note"
                                                   data-bs-original-title="Edit Note" aria-label="Edit Note"></i>
                                            </div>
                                        </div>
                                        <div x-bind:class="$store.data.is_expanded({{ $transaction->id }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="d-flex w-100 justify-content-between transaction_list_{{ $transaction->id }}">
                                            <div class="d-flex mt-0 w-100 text-start">
                                                
                                                <textarea id="note_textarea_{{ $transaction->id }}" class="w-100 px-1 pt-1 fs-11 rounded note_textarea d-none" spellcheck="true">{{ $transaction->notes }}</textarea>
                                                <p id="note_display_{{ $transaction->id }}" class="fs-12 m-0 p-1 pe-2 w-100 alert alert-warning note_para @if (App\Helpers\Functions::is_empty($transaction->notes)) d-none @endif">{{ $transaction->notes }}</p>
                                                <div id="comment_saving_{{ $transaction->id }}" class="d-none" >
                                                    <x-saving_animate class="la-sm" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div>
                                    No Transactions Found
                                </div>
                            @endforelse
                        </div>
                    @elseif($transaction_status == 'Processing')
                        <div>
                            <span>We were unable to fetch all transactions earlier. Fetching Your Account Transactions again. Please wait ... </span>
                            <div id="loading_bars">
                                <x-loading />
                                Fetching Transactions
                            </div>
                        </div>
                    @else
                        <div>
                            Error Raised While Fetching or Updating Your Account Transactions
                        </div>
                    @endif

                </template> --}}

                <template x-if="$store.data.view == 'timeline'">

                    @if ($transaction_status == 'OK')
                        <div class="row timeline">
                            <div class="d-none d-md-block col-md-1 text-start position-relative">
                                <div class="timeline_navigation mt-7">
                                    @php krsort($grouped_transactions) @endphp
                                    @foreach ($grouped_transactions as $year => $temp_transactions)
                                        <a class="year_links rounded-pill btn btn-sm p-0 btn-soft-ash mb-1 d-block" href="#{{ $year }}">{{ $year }}</a>
                                    @endforeach()
                                </div>
                            </div>

                            <div id="transactions_area" class="col-12 col-md-11 timeline_content_holder position-relative">
                                @forelse ($grouped_transactions as $year => $temp_transactions)
                                    <div class="timeline_year_wrapper" data-before-content="{{ $year }}" id="{{ $year }}">
                                        <div class="timeline_year border border-secondary my-1">
                                            @foreach ($temp_transactions as $transaction)
                                                @if ($loop->first)
                                                    @php
                                                        $fdt = $transaction['fixed_date'];
                                                        $on_date_change = true;
                                                    @endphp
                                                @endif

                                                @if ($fdt != $transaction['fixed_date'])
                                                    @php
                                                        $fdt = $transaction['fixed_date'];
                                                        $on_date_change = true;
                                                    @endphp
                                                @endif

                                                @if ($on_date_change)
                                                    <div class="daily_timeline">
                                                        <div class="timeline_date_2 text-start fs-14 py-1">
                                                            <span class="ms-4">{{ Carbon\Carbon::parse($transaction['fixed_date'])->format('d F Y') }}</span>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="timeline_details">
                                                    <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                                        <div class="list-group w-100">
                                                            <div class="d-flex w-100">
                                                                <div class="w-100">
                                                                    {{-- <p class="ficon m-0 w-100 lh1_3 text-start pointer" x-on:click="$store.data.toggleTransaction('timeline',{{ $transaction['id'] }})"> --}}
                                                                        {{-- <small class="text-muted fw-normal fs-11">12:02:46 PM</small> --}}
                                                                        <pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" x-on:click="$store.data.toggleTransaction('timeline',{{ $transaction['id'] }})" class="p-0 ficon m-0 w-100 lh1_3 text-start pointer mb-1 fw-bold text-dark d-block fs-14">@if(App\Helpers\Functions::not_empty($transaction['remit_info_unstructured'])){!! nl2br($transaction['remit_info_unstructured']) !!} @elseif(App\Helpers\Functions::not_empty($transaction['remittance_information_structured'])) {!! nl2br($transaction['remittance_information_structured']) !!} @else {!! nl2br(json_decode($transaction['remittance_information_unstructured_array'])[0]) !!} @endif<span><i id="transaction_timeline_icon_{{ $transaction['id'] }}" x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'uil-arrow-up' : 'uil-arrow-down'" class="uil v-middle fs-20 text-muted"></i></span></pre>
                                                                    {{-- </p> --}}
                                                                    <div x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="d-flex w-100 justify-content-between transaction_timeline_{{ $transaction['id'] }}">
                                                                        <div class="dropdown">
                                                                            <button class="btn border-primary text-primary border-1 btn-sm dropdown-toggle fs-12 py-0 px-2" id="timeline_view_category_toggle_{{ $transaction['id'] }}"
                                                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                @if (App\Helpers\Functions::is_empty($transaction['category_id']))
                                                                                Uncategorized @else {{ $transaction['category']['name'] }} <small
                                                                                           class="ms-2 fs-11 text-capitalize @if ($transaction['category']['type'] == 'income') text-green @else text-red @endif">{{ $transaction['category']['type'] }}</small>
                                                                                @endif
                                                                            </button>
                                                                            <ul class="dropdown-menu border shadow-lg lh-1 px-0 py-1" aria-labelledby="timeline_view_category_toggle_{{ $transaction['id'] }}"
                                                                                style="height: 280px; min-width: 230px; overflow-y: auto; overflow-x: hidden;">
                                                                                <li class="dropdown-list-item d-flex align-items-center justify-content-between">
                                                                                    <span x-on:click="$store.data.change_category({{ $transaction['id'] }},null)"
                                                                                          class="dropdown-item fs-12 lh-1 px-3 py-1 @if (App\Helpers\Functions::is_empty($transaction['category_id'])) active @endif">Uncategorized</span>
                                                                                </li>
                                                                                @foreach ($categories as $category)
                                                                                    @if (((float) $transaction['transaction_amount'] < 0 && $category['type'] == 'expense') || ((float) $transaction['transaction_amount'] >= 0 && $category['type'] == 'income'))
                                                                                        <li class="dropdown-list-item d-flex align-items-center justify-content-between">
                                                                                            <span x-on:click="$store.data.change_category({{ $transaction['id'] }}, {{ $category['id'] }})"
                                                                                                  class="dropdown-item fs-12 lh-1 px-3 py-2 @if ($category['id'] == $transaction['category_id']) active @endif">{{ $category['name'] }}</span>
                                                                                            <small
                                                                                                   class="text-capitalize badge @if ($category['type'] == 'income') bg-green @else bg-red @endif rounded-pill py-1">{{ $category['type'] }}</small>
                                                                                        </li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>

                                                                            <div id="cat_update_loader_{{ $transaction['id'] }}" class="d-none">
                                                                                <x-loading />
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="text-start mb-1 transaction_timeline_{{ $transaction['id'] }}">
                                                                        <div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Transaction ID:</strong></small></div><div class="col-md-12 col-lg-7 lh1_3 p-0">{{ $transaction['custom_uid'] }}</div></div>
                                                                        @if(App\Helpers\Functions::not_empty($transaction['debator_name']) || App\Helpers\Functions::not_empty($transaction['debtor_account']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Debitor:</strong></small></div> <div class="col-md-12 col-lg-7 lh1_3 p-0">@if(App\Helpers\Functions::not_empty($transaction['debator_name'])) {{ $transaction['debator_name'] }} @endif @if(App\Helpers\Functions::not_empty($transaction['debtor_account'])) (<small>{{ $transaction['debtor_account'] }}</small>) @endif </div> </div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['debtor_agent']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Debtor Agent:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['debtor_agent'] }}</div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['ultimate_debtor']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Ultimate Debtor:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['ultimate_debtor'] }}</div></div>@endif
                                                                        
                                                                        @if(App\Helpers\Functions::not_empty($transaction['creditor_name']) || App\Helpers\Functions::not_empty($transaction['creditor_account']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Creditor:</strong></small></div> <div class="col-md-12 col-lg-7 lh1_3 p-0">@if(App\Helpers\Functions::not_empty($transaction['creditor_name'])) {{ $transaction['creditor_name'] }} @endif @if(App\Helpers\Functions::not_empty($transaction['creditor_account'])) (<small>{{ $transaction['creditor_account'] }}</small>) @endif </div> </div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['creditor_agent']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Creditor Agent:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['creditor_agent'] }}</div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['creditor_id']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Creditor ID:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['creditor_id'] }}</div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['ultimate_creditor']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Ultimate Creditor:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['ultimate_creditor'] }}</div></div>@endif
                                                                        
                                                                        @if(App\Helpers\Functions::not_empty($transaction['bank_transaction_code']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Bank Transaction Code:</strong></small></div><div class="col-md-12 col-lg-7 lh1_3 p-0"> {{ $transaction['bank_transaction_code'] }} </div></div> @endif  
                                                                        @if(App\Helpers\Functions::not_empty($transaction['purpose_code']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Purpose Code:</strong></small></div><div class="col-md-12 col-lg-7 lh1_3 p-0"> {{ $transaction['purpose_code'] }} </div></div> @endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['proprietary_bank_transaction_code']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Proprietary Bank Transaction Code:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['proprietary_bank_transaction_code'] }}</div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['mandate_id']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Mandate ID:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['mandate_id'] }}</div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['check_id']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Check ID:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['check_id'] }}</div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['end_to_end_id']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>End to End ID:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['end_to_end_id'] }}</div></div>@endif
                                            
                                                                        @if(App\Helpers\Functions::not_empty($transaction['status']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Status:</strong> </small></div><div class="col-md-12 col-lg-7 lh1_3 p-0 text-capitalize"> {{ $transaction['status'] }}</div></div>@endif
                                                                        
                                                                        @if(App\Helpers\Functions::not_empty($transaction['balance_after_transaction']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Balance After Transaction:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['balance_after_transaction'] }}</div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['currency_exchange']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Currency Exchange:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['currency_exchange'] }}</div></div>@endif
                                                                        
                                                                        @if(App\Helpers\Functions::not_empty($transaction['remittance_information_structured']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Remittance Information Structured:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0">{{ $transaction['remittance_information_structured'] }}</pre></div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['remittance_information_structured_array']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Remittance Information Structured Array:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0">{{ $transaction['remittance_information_structured_array'] }}</pre></div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['remit_info_unstructured']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Remittance Information Unstructured:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0">{!! nl2br($transaction['remit_info_unstructured']) !!}</pre></div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['remittance_information_unstructured_array']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Remittance Information Unstructured Array:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0">{!! nl2br($transaction['remittance_information_unstructured_array']) !!}</pre></div></div>@endif
                                                                        
                                                                        @if(App\Helpers\Functions::not_empty($transaction['additional_information']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Additional Information:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['additional_information'] }}</div></div>@endif
                                                                        @if(App\Helpers\Functions::not_empty($transaction['additional_information_structured']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Additional Information Structured:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['additional_information_structured'] }}</div></div>@endif
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex w-20 align-items-end flex-column justify-content-between">
                                                                    <p class="ficon mb-0 fw-bold fs-14 @if((float)$transaction['transaction_amount'] > 0) text-primary @else text-danger @endif">{{ $transaction['transaction_currency'] }} {{ $transaction['transaction_amount'] }}</p>
                                                                    <div x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="transaction_timeline_{{ $transaction['id'] }}">
                                                                        <i x-on:click="$store.data.noteTrigger({{ $transaction['id'] }},'add')"
                                                                           class="uil uil-comment-alt-plus comment_btn @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-block @else d-none @endif" onclick="makevisible({{ $transaction['id'] }})"
                                                                           id="add_note_{{ $transaction['id'] }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note" data-bs-original-title="Add Note"
                                                                           aria-label="Add Note"></i>
                                                                        <i x-on:click="$store.data.noteTrigger({{ $transaction['id'] }},'edit')"
                                                                           class="uil uil-comment-alt-edit comment_btn @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-none @else d-block @endif" onclick="makevisible({{ $transaction['id'] }})"
                                                                           id="edit_note_{{ $transaction['id'] }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Edit Note" data-bs-original-title="Edit Note"
                                                                           aria-label="Edit Note"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="d-flex w-100 justify-content-between transaction_timeline_{{ $transaction['id'] }}">
                                                            <div class="d-flex mt-0 w-100 text-start">
                                                                <textarea id="note_textarea_{{ $transaction['id'] }}" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true">{{ $transaction['notes'] }}</textarea>
                                                                <p id="note_display_{{ $transaction['id'] }}" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-none @endif">{{ $transaction['notes'] }}</p>
                                                                <div id="comment_saving_{{ $transaction['id'] }}" class="d-none" >
                                                                    <x-saving_animate class="la-sm" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>


                                                @if ($on_date_change)
                                                    @php $on_date_change = false; @endphp
                                                    {{-- </div> --}}
                                                @endif
                                            @endforeach

                                        </div>
                                    </div>
                                @empty
                                    <div>
                                        No Transactions Found
                                    </div>
                                @endforelse

                                </div>
                            </div>
                    @elseif($transaction_status == 'Processing')
                        <div>
                            <span>We were unable to fetch all transactions earlier. Fetching Your Account Transactions again. Please wait ... </span>
                            <div id="loading_bars">
                                <x-loading />
                                Fetching Transactions
                            </div>
                        </div>
                    @else
                        <div>
                            Error Raised While Fetching or Updating Your Account Transactions
                        </div>
                        @endif

                </template>

                <template x-if="$store.data.view == 'timeline2'">

                    @if ($transaction_status == 'OK')
                        <div id="transactions_area" class="timeline">

                            @forelse ($transactions as $transaction)
                                @if ($loop->first)
                                    @php
                                        $fdt = $transaction['fixed_date'];
                                        $on_date_change = true;
                                    @endphp
                                @endif

                                @if ($fdt != $transaction['fixed_date'])
                                    @php
                                        $fdt = $transaction['fixed_date'];
                                        $on_date_change = true;
                                    @endphp
                        </div> {{-- Closing for <div class="timeline_transaction position-relative ms-4"> --}}
                    @endif

                    @if ($on_date_change)
                        @php $on_date_change = false; @endphp
                        <div class="timeline_transaction position-relative ms-4">
                            <div class="timeline_date text-start fs-14 mb-4 pt-6">{{ Carbon\Carbon::parse($transaction['fixed_date'])->format('d F Y') }}</div>
                    @endif

                    <div class="transaction_neutral timeline_details">
                        <div class="shadow-lg px-2 py-1 mb-1 bg-body rounded container-fluid">
                            <div class="list-group w-100">
                                <div class="d-flex w-100 ">
                                    <div class="ficon m-0 w-100 text-start t2_para" >
                                        {{-- <small class="text-muted fw-normal fs-11">12:02:46 PM</small> --}}
                                        <pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0 d-block fw-bold text-dark fs-14 pointer" x-on:click="$store.data.toggleTransaction('timeline_2',{{ $transaction['id'] }})">@if(App\Helpers\Functions::not_empty($transaction['remit_info_unstructured'])){!! nl2br($transaction['remit_info_unstructured']) !!} @elseif(App\Helpers\Functions::not_empty($transaction['remittance_information_structured'])) {!! nl2br($transaction['remittance_information_structured']) !!} @else {!! nl2br(json_decode($transaction['remittance_information_unstructured_array'])[0]) !!} @endif <span><i id="transaction_timeline_2_icon_{{ $transaction['id'] }}" x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'uil-arrow-up' : 'uil-arrow-down'" class="uil v-middle fs-18 text-muted"></i></span></pre>
                                        <div x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="text-start my-1 transaction_timeline_2_{{ $transaction['id'] }}">
                                            <div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Transaction ID:</strong></small></div><div class="col-md-12 col-lg-7 lh1_3 p-0">{{ $transaction['custom_uid'] }}</div></div>
                                            @if(App\Helpers\Functions::not_empty($transaction['debator_name']) || App\Helpers\Functions::not_empty($transaction['debtor_account']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Debitor:</strong></small></div> <div class="col-md-12 col-lg-7 lh1_3 p-0">@if(App\Helpers\Functions::not_empty($transaction['debator_name'])) {{ $transaction['debator_name'] }} @endif @if(App\Helpers\Functions::not_empty($transaction['debtor_account'])) (<small>{{ $transaction['debtor_account'] }}</small>) @endif </div> </div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['debtor_agent']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Debtor Agent:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['debtor_agent'] }}</div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['ultimate_debtor']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Ultimate Debtor:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['ultimate_debtor'] }}</div></div>@endif
                                                                        
                                            @if(App\Helpers\Functions::not_empty($transaction['creditor_name']) || App\Helpers\Functions::not_empty($transaction['creditor_account']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Creditor:</strong></small></div> <div class="col-md-12 col-lg-7 lh1_3 p-0">@if(App\Helpers\Functions::not_empty($transaction['creditor_name'])) {{ $transaction['creditor_name'] }} @endif @if(App\Helpers\Functions::not_empty($transaction['creditor_account'])) (<small>{{ $transaction['creditor_account'] }}</small>) @endif </div> </div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['creditor_agent']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Creditor Agent:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['creditor_agent'] }}</div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['creditor_id']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Creditor ID:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['creditor_id'] }}</div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['ultimate_creditor']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Ultimate Creditor:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['ultimate_creditor'] }}</div></div>@endif
                                                                        
                                            @if(App\Helpers\Functions::not_empty($transaction['bank_transaction_code']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Bank Transaction Code:</strong></small></div><div class="col-md-12 col-lg-7 lh1_3 p-0"> {{ $transaction['bank_transaction_code'] }} </div></div> @endif  
                                            @if(App\Helpers\Functions::not_empty($transaction['purpose_code']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Purpose Code:</strong></small></div><div class="col-md-12 col-lg-7 lh1_3 p-0"> {{ $transaction['purpose_code'] }} </div></div> @endif
                                            @if(App\Helpers\Functions::not_empty($transaction['proprietary_bank_transaction_code']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Proprietary Bank Transaction Code:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['proprietary_bank_transaction_code'] }}</div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['mandate_id']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Mandate ID:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['mandate_id'] }}</div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['check_id']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Check ID:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['check_id'] }}</div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['end_to_end_id']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>End to End ID:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['end_to_end_id'] }}</div></div>@endif
                                                                        
                                            @if(App\Helpers\Functions::not_empty($transaction['status']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1 mb-lg-0"><div class="col-md-12 col-lg-5 lh1_3 p-0"><small><strong>Status:</strong> </small></div><div class="col-md-12 col-lg-7 lh1_3 p-0 text-capitalize"> {{ $transaction['status'] }}</div></div>@endif
                                            
                                            @if(App\Helpers\Functions::not_empty($transaction['balance_after_transaction']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Balance After Transaction:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['balance_after_transaction'] }}</div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['currency_exchange']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Currency Exchange:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['currency_exchange'] }}</div></div>@endif
                                                                        
                                            @if(App\Helpers\Functions::not_empty($transaction['remittance_information_structured']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Remittance Information Structured:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0">{{ $transaction['remittance_information_structured'] }}</pre></div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['remittance_information_structured_array']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Remittance Information Structured Array:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0">{{ $transaction['remittance_information_structured_array'] }}</pre></div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['remit_info_unstructured']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Remittance Information Unstructured:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0">{!! nl2br($transaction['remit_info_unstructured']) !!}</pre></div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['remittance_information_unstructured_array']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Remittance Information Unstructured Array:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"><pre style="font-family: 'Manrope', sans-serif;white-space: pre-wrap;" class="p-0">{!! nl2br($transaction['remittance_information_unstructured_array']) !!}</pre></div></div>@endif

                                            @if(App\Helpers\Functions::not_empty($transaction['additional_information']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Additional Information:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['additional_information'] }}</div></div>@endif
                                            @if(App\Helpers\Functions::not_empty($transaction['additional_information_structured']))<div class="w-100 text-dark fs-14 text-start row m-0 mb-1"><div class="col-12 col-lg-5 lh1_3 p-0"><small><strong>Additional Information Structured:</strong> </small></div><div class="col-12 col-lg-7 lh1_3 p-0"> {{ $transaction['additional_information_structured'] }}</div></div>@endif
                                        </div>
                                    </div>
                                    <div class="d-flex w-20 align-items-end flex-column">
                                        <p class="ficon mb-0 @if((float)$transaction['transaction_amount'] > 0) text-primary @else text-danger @endif fs-14 fw-bold">{{ $transaction['transaction_currency'] }} {{ $transaction['transaction_amount'] }}</p>
                                        <div x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="transaction_timeline_2_{{ $transaction['id'] }}">
                                            <i x-on:click="$store.data.noteTrigger({{ $transaction['id'] }},'add')" class="uil uil-comment-alt-plus comment_btn @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-block @else d-none @endif"
                                            onclick="makevisible({{ $transaction['id'] }})" id="add_note_{{ $transaction['id'] }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note" data-bs-original-title="Add Note"
                                            aria-label="Add Note"></i>
                                            <i x-on:click="$store.data.noteTrigger({{ $transaction['id'] }},'edit')" class="uil uil-comment-alt-edit comment_btn @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-none @else d-block @endif"
                                            onclick="makevisible({{ $transaction['id'] }})" id="edit_note_{{ $transaction['id'] }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Edit Note" data-bs-original-title="Edit Note"
                                            aria-label="Edit Note"></i>
                                        </div>
                                    </div>
                                </div>
                                <div x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="d-flex w-100 justify-content-between transaction_timeline_2_{{ $transaction['id'] }}">
                                    <div class="dropdown">
                                        <button class="btn border-primary text-primary border-1 btn-sm dropdown-toggle fs-12 py-0 px-2" id="timeline2_view_category_toggle_{{ $transaction['id'] }}" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            @if (App\Helpers\Functions::is_empty($transaction['category_id']))
                                            Uncategorized @else {{ $transaction['category']['name'] }} <small
                                                    class="ms-2 fs-11 text-capitalize @if ($transaction['category']['type'] == 'income') text-green @else text-red @endif">{{ $transaction['category']['type'] }}</small>
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu border shadow-lg lh-1 px-0 py-1" aria-labelledby="timeline2_view_category_toggle_{{ $transaction['id'] }}" style="height: 280px; min-width: 230px; overflow-y: auto; overflow-x: hidden;">
                                            <li class="dropdown-list-item d-flex align-items-center justify-content-between">
                                                <span x-on:click="$store.data.change_category({{ $transaction['id'] }},null)" class="dropdown-item fs-12 lh-1 px-3 py-1 @if (App\Helpers\Functions::is_empty($transaction['category_id'])) active @endif">Uncategorized</span>
                                            </li>
                                            @foreach ($categories as $category)
                                                @if (((float) $transaction['transaction_amount'] < 0 && $category['type'] == 'expense') || ((float) $transaction['transaction_amount'] >= 0 && $category['type'] == 'income'))
                                                    <li class="dropdown-list-item d-flex align-items-center justify-content-between">
                                                        <span x-on:click="$store.data.change_category({{ $transaction['id'] }}, {{ $category['id'] }})"
                                                            class="dropdown-item fs-12 lh-1 px-3 py-2 @if ($category['id'] == $transaction['category_id']) active @endif">{{ $category['name'] }}</span>
                                                        <small class="text-capitalize badge @if ($category['type'] == 'income') bg-green @else bg-red @endif rounded-pill py-1">{{ $category['type'] }}</small>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>

                                        <div id="cat_update_loader_{{ $transaction['id'] }}" class="d-none">
                                            <x-loading />
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div x-bind:class="$store.data.is_expanded({{ $transaction['id'] }}) ? 'transaction_expanded' : 'transaction_collapsed'" class="d-flex w-100 pb-3 justify-content-between transaction_timeline_2_{{ $transaction['id'] }}">
                            <div class="d-flex mt-0 w-100 text-start">
                                <textarea id="note_textarea_{{ $transaction['id'] }}" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true">{{ $transaction['notes'] }}</textarea>
                                <p id="note_display_{{ $transaction['id'] }}" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-none @endif">{{ $transaction['notes'] }}</p>
                                <div id="comment_saving_{{ $transaction['id'] }}" class="d-none" >
                                    <x-saving_animate class="la-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div>
                            No Transactions Found
                        </div>
                        @endforelse
                        </div> {{-- Final Closing for <div class="timeline_transaction position-relative ms-4"> --}}
                        </div>
                    @elseif($transaction_status == 'Processing' || $transaction_status == 'Processing and Refreshing' )
                        <div>
                            @if($transaction_status == 'Processing')
                            <span>We were unable to fetch all transactions earlier. Fetching Your Account Transactions again. Please wait ... </span>
                            @else
                            <span>Refreshing Your Account Transactions. Please wait ... </span>
                            @endif
                            <div id="loading_bars">
                                <x-loading />
                                Fetching Transactions
                            </div>
                        </div>
                    @else
                        <div>
                            Server Error Raised While Fetching or Updating Your Account Transactions
                        </div>
                        @endif

                </template>

                <template x-if="$store.data.transactions_loading">
                    <div id="loading_bars">
                        <x-loading />
                        Loading Transactions
                    </div>
                </template>

            </div>
        </section>
    </div>
    <div wire:ignore.self class="modal fade" id="shareform">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                    <h5 class="text-start">Share with people</h5>
                    <div class="d-flex">
                        <input wire:model.debounce.1000ms="email" type="email" id="textarea" class="p-1 form-control" placeholder="Email">
                        <button wire:click="add_shared_user" id="addUserBtn" type="button" class="btn btn-sm btn-dark border-0 rounded-pill py-0 ms-3">
                            <i class="uil p-0 uil-user-plus text-white"></i>
                        </button>
                    </div>
                    <div class="form-check">
                        <input wire:model="share_notes" type="checkbox" id="share_notes" class="p-1 form-check-input"> 
                        <label class="form-check-label text-start" for="share_notes">Share along with Transaction Notes</label>
                    </div>
                    <div class="form-check">
                        <input wire:model="share_balance" type="checkbox" id="share_balance" class="p-1 form-check-input"> 
                        <label class="form-check-label text-start" for="share_balance">Share along with Account Balance</label>
                    </div>
                    @if(App\Helpers\Functions::not_empty($error))<div class="text-start lh-1"><small class="text-danger">{{$error}}</small></div>@endif
                    @if(App\Helpers\Functions::not_empty($success))<div class="text-start lh-1"><small class="text-success">{{$success}}</small></div>@endif
                    <p class="text-muted text-start border-bottom fs-11 mt-4">Shared with</p>
                    <div id="listuser" class="d-block">
                        @forelse ($shared_emails as $se)
                            <div class="d-flex justify-content-between rounded bg-soft-ash m-1 p-2">
                                <div class="d-flex">
                                    <img class="h-5 me-1 rounded-circle" src='https://ui-avatars.com/api/?name={{$se['email']}}.jpg'/>
                                    <p class="m-0">{{$se['email']}}</p>
                                </div>
                                <a title="Remove" wire:click="remove_shared_user({{$se['id']}},'{{$se['type']}}')" class="float-end text-danger ms-2" style="cursor: pointer">
                                    <i class="uil uil-minus"></i>
                                </a>
                            </div>
                        @empty
                            Account is not shared with anyone!
                        @endforelse
                        
                    </div>
                    
                    <div>
                        <p class="text-muted text-start border-bottom fs-11 mt-4">Shareable Link</p>
                        @if(App\Helpers\Functions::is_empty($shareable_link))
                        <button wire:click="generate_shareable_link()" class="btn btn-sm btn-soft-orange rounded-pill py-0 px-2" type="button">Generate Shareable Link</button>
                        @else
                        <div class="">
                            
                            <p class="fs-14 alert alert-info px-2 py-1 mb-1" id="shareable_link">{{route('account.shareable.link', $shareable_link)}}</p>
                            <div class="d-flex justify-content-between"><a href="javascript:void(0)" onclick="copy_text()" class="btn btn-sm btn-soft-primary p-0 px-1">Copy</a> <a href="javascript:void(0)" class="btn btn-soft-red btn-sm p-0 px-1" wire:click="remove_shareable_link()" title="Remove"><i class="uil uil-trash-alt"></i></a></div>
                            <strong id="copy_toast" class="d-none">Link Copied !</strong>
                            <textarea style="display: none;" id="copyTextarea"></textarea>
                        </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('data', {
                view: "timeline",
                transactions_loading: false,
                all_loaded: false,
                active_id: null,
                active_action: null,
                expanded: [],

                change_view(view_name) {
                    this.view = view_name;
                    this.resetNoteTrigger();
                    init_tooltips();
                    Livewire.emit('refreshView');
                },
                toggleTransactionsLoading() {
                    this.transactions_loading = !this.transactions_loading;
                },
                allLoaded() {
                    this.all_loaded = true;
                },
                async noteTrigger(id, action) {
                    if (this.active_id != null) {
                        await makevisible(this.active_id);
                    }
                    this.active_id = id;
                    this.active_action = action;
                },
                async resetNoteTrigger() {
                    if (this.active_id != null) {
                        await makevisible(this.active_id);
                        this.active_id = null;
                    }
                    this.active_action = null;
                },
                async change_category(tid, cid) {
                    document.getElementById("cat_update_loader_" + tid).classList.remove('d-none');
                    await @this.updateCategory(tid, cid);
                    document.getElementById("cat_update_loader_" + tid).classList.add('d-none');
                },
                toggleTransaction(view, id){
                    elems = document.querySelectorAll('.transaction_'+view+'_'+id);
                    icon = document.getElementById('transaction_'+view+'_icon_'+id);
                    
                    elems.forEach((element) => {
                        if(element.classList.contains('transaction_collapsed')){
                            element.classList.remove('transaction_collapsed');
                        }
                        else{
                            element.classList.add('transaction_collapsed');
                            let index = this.expanded.indexOf(id);
                            if (index > -1) {
                                this.expanded.splice(index, 1);
                            }
                        }
                        if(element.classList.contains('transaction_expanded')){
                            element.classList.remove('transaction_expanded');
                        }
                        else{
                            element.classList.add('transaction_expanded');
                            this.expanded.push(id);
                        }
                        
                    });

                    if(icon.classList.contains('uil-arrow-down')){
                        icon.classList.remove('uil-arrow-down');
                    }
                    else{
                        icon.classList.add('uil-arrow-down');
                    }

                    if(icon.classList.contains('uil-arrow-up')){
                        icon.classList.remove('uil-arrow-up');
                    }
                    else{
                        icon.classList.add('uil-arrow-up');
                    }
                },
                is_expanded(id){
                    let index = this.expanded.indexOf(id);
                    if (index > -1) {
                        return true;
                    }
                    return false;
                }
            });
        });

        $(document).ready(function() {

            $("body").on('click', ".year_links", function(e) {
                let year = e.target.getAttribute("href");
                $('html,body').animate({
                        scrollTop: ($(year).offset().top - 61)
                    },
                    'slow');
            });

            window.livewire.on('allDataLoaded', () => {
                Alpine.store('data').allLoaded();
            });
            window.livewire.on('commentSaved', (data) => {
                setTimeout(function(){
                    document.getElementById("comment_saving_" + data).classList.add('d-none');
                },150);
            });
            window.livewire.on('transactionReFetched', () => {
                window.location.href = window.location.href;
                location.reload();
            });

            document.addEventListener('keydown', function(e) {
                if (e.target && e.target.id == 'note_textarea_' + Alpine.store('data').active_id) {
                    if (e.keyCode == 13 && e.shiftKey) {} else if (e.keyCode == 13) {
                        document.getElementById("comment_saving_" + Alpine.store('data').active_id).classList.remove('d-none');
                        @this.save_note(Alpine.store('data').active_id, e.target.value);
                        Alpine.store('data').resetNoteTrigger();
                    }
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target && (
                        e.target.id == 'note_textarea_' + Alpine.store('data').active_id ||
                        e.target.id == 'edit_note_' + Alpine.store('data').active_id ||
                        e.target.id == 'add_note_' + Alpine.store('data').active_id)) {

                } else {
                    if (Alpine.store('data').active_id != null) {
                        document.getElementById("comment_saving_" + Alpine.store('data').active_id).classList.remove('d-none');
                        let comment = document.getElementById('note_textarea_' + Alpine.store('data').active_id);
                        @this.save_note(Alpine.store('data').active_id, comment.value);
                        Alpine.store('data').resetNoteTrigger();
                    }
                }
            });

            let ticking = false;
            document.addEventListener('scroll', function(e) {
                let win = $(window).scrollTop() + $(window).innerHeight();
                let elem = $('#transactions_area').offset().top + $('#transactions_area').innerHeight();
                if (!Alpine.store('data').all_loaded && !Alpine.store('data').transactions_loading && (win >= elem + 50)) {
                    if (!ticking) {
                        ticking = true
                        Alpine.store('data').toggleTransactionsLoading();
                        setTimeout(async () => {
                            await @this.load_more();
                            Alpine.store('data').toggleTransactionsLoading();
                            ticking = false;
                            setTimeout(() => {
                                Array.from(document.querySelectorAll('i[data-bs-toggle="tooltip"]')).forEach(tooltipNode => new bootstrap.Tooltip(tooltipNode));
                            }, 300);
                        }, 500);
                    }
                }
            });

            init_tooltips();

            $('body').on('click', 'button.dropdown-toggle', (e) => {
                let button = e.target.closest('button.dropdown-toggle');
                let ul = button.nextElementSibling;
                if (!button.classList.contains('show')) {
                    button.setAttribute('aria-expanded', true);
                    button.classList.add('show');
                }
                if (!ul.classList.contains('show')) {
                    ul.classList.add('show');
                }
            });



        });

        function copy_text() {
            var copyText = document.getElementById("shareable_link").innerHTML;
            var copy = document.getElementById("copyTextarea");
            copy.value = copyText;
            copy.select();
            copy.setSelectionRange(0, 99999);
            document.execCommand("copy");

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(copyText);
            }

            var copy_text_notify = document.getElementById('copy_toast');
            copy_text_notify.classList.toggle('d-none');
            setTimeout(() => {
                copy_text_notify.classList.toggle('d-none');
            }, 2000);
        }

        function init_tooltips() {
            setTimeout(() => {
                var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'))
                var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl)
                });

                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            }, 300);
        }
    </script>
@endpush
