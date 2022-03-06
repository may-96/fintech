@extends('layouts.auth')
@section('css')
<style>
    .accordion-button{
        cursor: pointer;
        width: 100%;
        padding: 0 0 0 0;
        text-align: left;
        margin: 0;
        border: 0;
        font-size: 0.7rem;
        font-weight: 700;
        color: #60697b;
        transition: all 150ms ease-in-out;
        background: none;
    }
    .v-top{
        vertical-align: text-top;
    }
</style>
@endsection

@section('content')
    <div class="container-fluid px-10 d-flex justify-content-center bg-gray h-100">
        <div class="row d-flex justify-content-center align-content-between" style="width: 80rem;">
            <div class="mt-6">
                <p class="text-primary fs-28 fw-bold"><a href="{{ route('index') }}">Revolut</a></p>
            </div>
            <div class="row gy-4 justify-content-evenly">
                <div class="text-center display-6">Overview of the connected @if (count($accounts) > 1) Accounts @else Account @endif</div>

                @foreach ($accounts as $account)
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card p-3 w-100">
                            <div>
                                <h5 class="fs-16 lh-1 mb-0">
                                    @if (isset($account->iban))
                                {{ $account->iban }} @elseif(isset($account->bban)) {{ $account->bban }} @else {{ $account->resource_id }}
                                @endif
                            </h5>
                            <small class="text-muted">
                                @if (isset($account->bic))
                                {{ $account->bic }} @else {{ $account->msisdn }}
                                @endif
                            </small>
                            <p class="mb-6 text-primary">
                                @if (isset($account->owner_name))
                                {{ $account->owner_name }} @else {{ $account->display_naem }}
                                @endif
                            </p>
                        </div>
                        <div>
                            @if (isset($account->account_name))
                                <p class="m-0 lh-1 fs-14">{{ $account->account_name }}</p>
                            @endif
                            <div class="clearfix">
                                <small class="text-muted float-start">Currency: <span class="text-dark">{{ $account->currency }}</span></small>
                                @if (isset($account->type_string))
                                    <small class="text-muted float-end">Type: <span class="text-dark">{{ $account->type_string }}</span></small>
                                @endif
                            </div>
                        </div>
                        <div class="">
                            @php
                                $transactions = $account->transactions;
                                $transaction_count = $transactions->count();
                            @endphp
                            <div class="mt-2 d-flex justify-content-between"><span class="fs-14 text-navy mb-1">Transaction Count: <strong>{{ $transaction_count }}</strong></span><a class="btn small btn-sm btn-soft-ash rounded-pill px-1 p-0" href="{{route('my.transactions',$account->account_id.'-'.$account->id)}}">Open Transactions</a></div>
                            <div>
                                @php
                                    $max_fetch = 10;
                                    if ($transaction_count < $max_fetch) {
                                        $max_fetch = $transaction_count;
                                    }
                                @endphp
                                <div class="accordion accordion-wrapper" id="recent_transaction_block_{{$account->id}}">
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="recent_transaction_heading_{{$account->id}}">
                                            <button class="accordion-button expand-collapse" data-id="{{$account->id}}" data-bs-toggle="collapse" data-bs-target="#recent_transactions_{{$account->id}}" aria-expanded="true" aria-controls="recent_transactions_{{$account->id}}">Recent Transactions <i id="recent_transaction_icon_{{$account->id}}" data-id="{{$account->id}}" class="expand-collapse v-top uil uil-angle-down"></i></button>
                                        </div>

                                        <div id="recent_transactions_{{$account->id}}" class="accordion-collapse collapse" aria-labelledby="recent_transaction_heading_{{$account->id}}" data-bs-parent="#recent_transaction_block_{{$account->id}}">
                                            @for ($i = 0; $i < $max_fetch; $i++)
                                                <div class="bg-gray border-top p-1">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="m-0 fs-14">{{ $transactions[$i]->custom_uid }}</p>
                                                        <p class="m-0 fs-14">{{ $transactions[$i]->transaction_currency }} {{ $transactions[$i]->transaction_amount }}</p>
                                                    </div>
                                                    <small class="text-muted">{{ Carbon\Carbon::parse($transactions[$i]->fixed_date)->format('d F, Y') }}</small>
                                                </div>
                                            @endfor
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            @endforeach
        </div>


        <div class="align-self-end text-center">
            <p class="m-0">© {{ config('app.name') }} 2021</p>
            <small>All Rights Reserved</small>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('.expand-collapse').on('click', function(e) {
        let id = e.target.dataset.id;
        e.stopPropagation();
        let elem = document.getElementById('recent_transactions_'+id);
        let icon = document.getElementById('recent_transaction_icon_'+id);
        elem.classList.toggle('show');
        icon.classList.toggle('uil-angle-down');
        icon.classList.toggle('uil-angle-up');
    });
</script>
@endsection
