<section>
    <div class="content-wrapper ">
        <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
            <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">

                @if (!empty($balances))
                    <div class="row mb-6 gy-4 justify-content-center">
                        @foreach ($balances as $balance)
                            @if ($balance->type == 'expected')
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    <div class="card card bg-soft-blue border-blue big_border_bottom">
                                        <div class="card-body text-start px-4 py-2">
                                            <h5 class="card-title">{{ $balance->currency }} {{ $balance->amount }}</h5>
                                            <p class="card-text fs-14">Expected Balance</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($balance->type == 'closingBooked')
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    <div class="card card bg-soft-yellow border-yellow big_border_bottom">
                                        <div class="card-body text-start px-4 py-2">
                                            <h5 class="card-title">{{ $balance->currency }} {{ $balance->amount }}</h5>
                                            <p class="card-text fs-14">Closing Balance</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif


                <h2 class="h1 fs-46 text-center">Transactions</h2>
                <div class="d-inline-block text-center mb-10">
                    <button title="List View" class="btn btn-circle @if ($view == 'list') btn-soft-primary @else btn-soft-ash @endif" type="button" wire:click="switch_view('list')"><i class="uil uil-list-ul"></i></button>
                    <button title="Timeline View 1" class="btn btn-circle @if ($view == 'timeline') btn-soft-primary @else btn-soft-ash @endif" type="button" wire:click="switch_view('timeline')"><i class="uil uil-calendar-alt"></i></button>
                    <button title="Timeline View 2" class="btn btn-circle @if ($view == 'timeline2') btn-soft-primary @else btn-soft-ash @endif" type="button" wire:click="switch_view('timeline2')"><i class="uil uil-chart-bar-alt"></i></button>
                </div>

                @if ($view == 'list')

                    @if ($transaction_status == 'OK')
                        <div id="transactions_area">
                            @forelse($transactions as $transaction)
                                <div class="shadow-lg px-3 pt-2 pb-1 mb-2 bg-body rounded container-fluid border-navy big_border_left">
                                    <div class="list-group w-100 mx-1">
                                        <div class="d-flex w-100 justify-content-between fw-bold text-dark">
                                            <p class="ficon mb-1">{{ $transaction->custom_uid }}</p>
                                            <p class="ficon mb-1 text-primary">{{ $transaction->transaction_currency }} {{ $transaction->transaction_amount }}</p>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="d-flex mb-1 flex-column text-start">
                                                <small>{{ $transaction->remit_info_unstructured }}</small>
                                                <small class="text-muted">{{ $transaction->fixed_date }}</small>
                                            </p>
                                            <div class="d-flex mt-0 text-start align-items-end">
                                                <i class="uil uil-comment-alt-plus comment_btn @if (App\Helpers\Functions::is_empty($transaction->notes)) d-block @else d-none @endif" onclick="makevisible({{ $transaction->id }})" id="add_note_{{ $transaction->id }}" data-bs-toggle="tooltip"
                                                   data-bs-placement="right" title="Add Note" data-bs-original-title="Add Note" aria-label="Add Note"></i>
                                                <i class="uil uil-comment-alt-edit comment_btn @if (App\Helpers\Functions::is_empty($transaction->notes)) d-none @else d-block @endif" onclick="makevisible({{ $transaction->id }})" id="edit_note_{{ $transaction->id }}" data-bs-toggle="tooltip"
                                                   data-bs-placement="right" title="Edit Note" data-bs-original-title="Edit Note" aria-label="Edit Note"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between ">
                                            <div class="d-flex mt-0 w-100 text-start">
                                                <textarea wire:keydown.enter="save_note({{ $transaction->id }},$event.target.value)" id="note_textarea_{{ $transaction->id }}" class="w-100 px-1 pt-1 fs-11 rounded note_textarea d-none" spellcheck="true">{{ $transaction->notes }}</textarea>
                                                <p id="note_display_{{ $transaction->id }}" class="fs-12 m-0 p-1 pe-2 w-100 alert alert-info note_para @if (App\Helpers\Functions::is_empty($transaction->notes)) d-none @endif">{{ $transaction->notes }}</p>
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
                            Fetching Your Account Transactions
                        </div>
                    @else
                        <div>
                            Error Raised While Fetching or Updating Your Account Transactions
                        </div>
                    @endif



                @elseif($view == 'timeline')
                    @if ($transaction_status == 'OK')
                        <div class="row timeline">
                            <div class="d-none d-md-block col-md-1 text-start position-relative">
                                <div class="timeline_navigation mt-7">
                                    @php krsort($grouped_transactions) @endphp
                                    @foreach ($grouped_transactions as $year => $temp_transactions)
                                        <a class="year_links rounded-pill btn btn-sm py-0 btn-soft-ash mb-1 d-block" href="#{{ $year }}">{{ $year }}</a>
                                    @endforeach()
                                </div>
                            </div>

                            <div id="transactions_area" class="col-12 col-md-11 timeline_content_holder position-relative">
                                @foreach ($grouped_transactions as $year => $temp_transactions)
                                    <div class="timeline_year_wrapper" data-before-content="{{ $year }}" id="{{ $year }}">
                                        <div class="timeline_year border border-secondary my-1">
                                            @foreach ($temp_transactions as $transaction)

                                                @if ($loop->first) @php $fdt = $transaction["fixed_date"]; $on_date_change = true; @endphp @endif

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
                                                @endif

                                                        <div class="timeline_details">
                                                            <div class="px-2 py-1 border-bottom bg-body container-fluid">
                                                                <div class="list-group w-100">
                                                                    <div class="d-flex w-100">
                                                                        <p class="ficon m-0 w-100 lh1_3 text-start">
                                                                            {{-- <small class="text-muted fw-normal fs-11">12:02:46 PM</small> --}}
                                                                            <span class="mb-1 fw-bold text-dark d-block fs-14">{{ $transaction['custom_uid'] }}</span>
                                                                            <small class="w-100 text-start">{{ $transaction['remit_info_unstructured'] }}</small>
                                                                        </p>
                                                                        <div class="d-flex w-25 align-items-end flex-column justify-content-between">
                                                                            <p class="ficon mb-0 text-primary">{{ $transaction['transaction_currency'] }} {{ $transaction['transaction_amount'] }}</p>
                                                                            <div class="">
                                                                                <i class="uil uil-comment-alt-plus comment_btn @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-block @else d-none @endif" onclick="makevisible({{ $transaction['id'] }})" id="add_note_{{ $transaction['id'] }}"
                                                                                data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note" data-bs-original-title="Add Note" aria-label="Add Note"></i>
                                                                                <i class="uil uil-comment-alt-edit comment_btn @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-none @else d-block @endif" onclick="makevisible({{ $transaction['id'] }})" id="edit_note_{{ $transaction['id'] }}"
                                                                                data-bs-toggle="tooltip" data-bs-placement="right" title="Edit Note" data-bs-original-title="Edit Note" aria-label="Edit Note"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex w-100 justify-content-between">
                                                                    <div class="d-flex mt-0 w-100 text-start">
                                                                        <textarea wire:keydown.enter="save_note({{ $transaction['id'] }},$event.target.value)" id="note_textarea_{{ $transaction['id'] }}"
                                                                                class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true">{{ $transaction['notes'] }}</textarea>
                                                                        <p id="note_display_{{ $transaction['id'] }}" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-info note_para @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-none @endif">{{ $transaction['notes'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>


                                                @if ($on_date_change)
                                                    @php $on_date_change = false; @endphp
                                                    </div>
                                                @endif

                                            @endforeach

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @elseif($transaction_status == 'Processing')
                        <div>
                            Fetching Your Account Transactions
                        </div>
                    @else
                        <div>
                            Error Raised While Fetching or Updating Your Account Transactions
                        </div>
                    @endif
                @else
                    @if ($transaction_status == 'OK')
                        <div id="transactions_area" class="timeline">

                            @foreach ($transactions as $transaction)

                                @if ($loop->first) @php $fdt = $transaction->fixed_date; $on_date_change = true; @endphp @endif

                                @if ($fdt != $transaction->fixed_date)
                                    @php
                                        $fdt = $transaction->fixed_date;
                                        $on_date_change = true;
                                    @endphp
                                    </div> {{-- Closing for <div class="timeline_transaction position-relative ms-4"> --}}
                                @endif

                                @if ($on_date_change)
                                    @php $on_date_change = false; @endphp
                                    <div class="timeline_transaction position-relative ms-4">
                                        <div class="timeline_date text-start fs-14 mb-4 pt-6">{{ Carbon\Carbon::parse($transaction->fixed_date)->format('d F Y') }}</div>
                                @endif

                                        <div class="transaction_neutral timeline_details">
                                            <div class="shadow-lg px-2 py-1 mb-1 bg-body rounded container-fluid">
                                                <div class="list-group w-100">
                                                    <div class="d-flex w-100 ">
                                                        <p class="ficon m-0 lh-1 w-100 text-start">
                                                            {{-- <small class="text-muted fw-normal fs-11">12:02:46 PM</small> --}}
                                                            <span class="mb-1 d-block fw-bold text-dark fs-14">{{ $transaction->custom_uid }}</span>
                                                            <small class="w-100 text-start">{{ $transaction->remit_info_unstructured }}</small>
                                                        </p>
                                                        <div class="d-flex w-25 align-items-end flex-column">
                                                            <p class="ficon mb-0 text-primary">{{ $transaction->transaction_currency }} {{ $transaction->transaction_amount }}</p>
                                                            <div class="">
                                                                <i class="uil uil-comment-alt-plus comment_btn @if (App\Helpers\Functions::is_empty($transaction->notes)) d-block @else d-none @endif" onclick="makevisible({{ $transaction->id }})" id="add_note_{{ $transaction->id }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Add Note" data-bs-original-title="Add Note" aria-label="Add Note"></i>
                                                                <i class="uil uil-comment-alt-edit comment_btn @if (App\Helpers\Functions::is_empty($transaction->notes)) d-none @else d-block @endif" onclick="makevisible({{ $transaction->id }})" id="edit_note_{{ $transaction->id }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Edit Note" data-bs-original-title="Edit Note" aria-label="Edit Note"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex w-100 pb-3 justify-content-between ">
                                                <div class="d-flex mt-0 w-100 text-start">
                                                    <textarea wire:keydown.enter="save_note({{ $transaction->id }},$event.target.value)" id="note_textarea_{{ $transaction->id }}" class="w-100 px-1 pt-1 fs-11 rounded note_textarea note_textarea_timeline d-none" spellcheck="true">{{ $transaction->notes }}</textarea>
                                                    <p id="note_display_{{ $transaction->id }}" class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-warning note_para @if (App\Helpers\Functions::is_empty($transaction->notes)) d-none @endif">{{ $transaction->notes }}</p>
                                                </div>
                                            </div>
                                        </div>

                            @endforeach
                            </div> {{-- Final Closing for <div class="timeline_transaction position-relative ms-4"> --}}
                        </div>
                    @elseif($transaction_status == 'Processing')
                        <div>
                            Fetching Your Account Transactions
                        </div>
                    @else
                        <div>
                            Error Raised While Fetching or Updating Your Account Transactions
                        </div>
                    @endif
                @endif

                @if ($transactions_loading)
                    <div id="loading_bars">
                        <x-loading />
                        Loading Transactions
                    </div>
                @endif
            </div>
        </section>
    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(function() {
            $("body").on('click', ".year_links", function(e) {
                let year = e.target.getAttribute("href");
                $('html,body').animate({
                        scrollTop: ($(year).offset().top - 61)
                    },
                    'slow');
            });
        });

        let ticking = false;
        document.addEventListener('scroll', function(e) {
            let win = $(window).scrollTop() + $(window).innerHeight();
            let elem = $('#transactions_area').offset().top + $('#transactions_area').innerHeight();
            if (!@this.all_loaded && !@this.transactions_loading && (win >= elem + 50)) {
                if (!ticking) {
                    ticking = true
                    @this.set('transactions_loading', true);
                    setTimeout(() => {
                        @this.load_more();
                        @this.set('transactions_loading', false);
                        ticking = false;
                        setTimeout(() => {
                            Array.from(document.querySelectorAll('i[data-bs-toggle="tooltip"]')).forEach(tooltipNode => new bootstrap.Tooltip(tooltipNode));
                        }, 300);
                    }, 500);
                }
            }
        });
    </script>
@endpush
