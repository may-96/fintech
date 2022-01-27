@extends('layouts.auth')
@section('css')

@endsection

@section('content')
    <div class="container-fluid px-10 d-flex justify-content-center bg-gray vh-100">
        <div class="row d-flex justify-content-center align-content-between" style="width: 80rem;">
            <div class="mt-6">
                <p class="text-primary fs-28 fw-bold"><a href="{{route('index')}}">Revolut</a></p>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="text-center display-6">Following @if(count($accounts) > 1) Accounts have @else Account has @endif been Linked</div>
                
                @foreach ($accounts as $account)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card p-3 w-100">
                        
                        <div>
                            <h5 class="fs-16 lh-1 mb-0">@if(isset($account->iban)) {{$account->iban}} @elseif(isset($account->bban)) {{$account->bban}} @else {{$account->resource_id}} @endif</h5>
                            <small class="text-muted">@if(isset($account->bic)) {{$account->bic}} @else {{$account->msisdn}} @endif</small>
                            <p class="mb-6 text-primary">@if(isset($account->owner_name)) {{$account->owner_name}} @else {{$account->display_naem}} @endif</p>
                        </div>
                        <div>
                            @if(isset($account->account_name))<p class="m-0 lh-1 fs-14">{{$account->account_name}}</p>@endif
                            <div class="clearfix">
                                <small class="text-muted float-start">Currency: <span class="text-dark">{{$account->currency}}</span></small>
                                @if(isset($account->type_string))<small class="text-muted float-end">Type: <span class="text-dark">{{$account->type_string}}</span></small>@endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="text-center">
                    <a href="{{route('my.accounts')}}" class="btn btn-primary">Open My Accounts</a>
                </div>
            </div>


            <div class="align-self-end text-center">
                <p class="m-0">© {{config('app.name')}} 2021</p>
                <small>All Rights Reserved</small>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection