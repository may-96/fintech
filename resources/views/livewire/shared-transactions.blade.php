<section>
    <div class="content-wrapper ">
        <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
            <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">

                {{-- <h2 class="h1 fs-46 text-center">Transactions</h2> --}}
                
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
                                                        <div class="px-2 py-2 border-bottom bg-body container-fluid">
                                                            <div class="list-group w-100">
                                                                <div class="d-flex w-100">
                                                                    <p class="ficon m-0 w-100 lh1_3 text-start">
                                                                        {{-- <small class="text-muted fw-normal fs-11">12:02:46 PM</small> --}}
                                                                        <span class="mb-1 fw-bold text-dark d-block fs-14">{{ $transaction['custom_uid'] }}</span>
                                                                        <small class="w-100 text-start">{{ $transaction['remit_info_unstructured'] }}</small>
                                                                    </p>
                                                                    <div class="d-flex w-25 align-items-end flex-column justify-content-between">
                                                                        <p class="ficon mb-0 text-primary">{{ $transaction['transaction_currency'] }} {{ $transaction['transaction_amount'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if($notes_shared == 1)
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <div class="d-flex mt-0 w-100 text-start">
                                                                    <p class="fs-12 m-0 mb-1 p-1 pe-2 w-100 alert alert-info note_para @if (App\Helpers\Functions::is_empty($transaction['notes'])) d-none @endif">{{ $transaction['notes'] }}</p>
                                                                </div>
                                                            </div>
                                                            @endif
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
            if (!@this.all_loaded && !@this.transactions_loading && (win >= elem + 150)) {
                if (!ticking) {
                    ticking = true
                    @this.set('transactions_loading', true);
                    setTimeout(() => {
                        @this.load_more();
                        @this.set('transactions_loading', false);
                        ticking = false;
                    }, 1000);
                }
            }
        });
    </script>
@endpush
