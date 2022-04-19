<div class="content-wrapper" x-data>
    <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
        <div id="form_area" class="container pt-10 pb-10 pt-md-14 text-center">
            {{-- <h2 class="h1 fs-46 mb-10 text-center mb-4">Request Report</h2> --}}
            <p class="mb-0">Enter Details below and share link to request a Credit Worthiness and Affordibility Report.</p>
            <form action="{{route('request.report.submit')}}" method="post">
                @csrf
                
                <div class="mt-5 mb-3">
                    <div class="text-start input-group">
                        <input id="amount" type="number" min="0" value="{{old('amount')}}" name="amount" class="form-control rounded-0 px-2 py-1 @error('amount') is-invalid @enderror" placeholder="Amount to be Paid Per Month (Rent Amount, Mortgage Amount etc)" required>
                        @php $currencies = DB::table('currencies')->select('currency','code')->distinct()->orderBy('code','asc')->get()->flatten(); @endphp
                        <select name="currency" class="form-select rounded-0" placeholder="Select Currency">
                            <option disabled value="">Select Currency</option>

                            @foreach($currencies as $index => $currency)
                            <option value="{{$currency->code}}" @if(old('currency') == $currency->code) selected @endif>{{ucwords($currency->currency)}} - {{$currency->code}}</option>
                            @endforeach
                        </select>
                        @error('amount')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                        @error('currency')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                <div class="text-start bg-white form-floating">
                    <div id="editor"></div>
                </div>
                
                <div>
                    <button class="btn btn-soft-primary rounded-pill mt-3" type="submit">Generate Link</button>
                </div>

            </form>

        </div>
        <div class="container">
            <div class="row"><h5>List of All Generated Links</h5></div>
            <div class="row ps-4">
                @forelse ($data as $index => $email)
                    <div class="col-12 mb-1 p-1 alert alert-primary d-flex justify-content-between">
                        <span class="ps-1 align-self-center">{{$email}}</span>
                        <a class="remove_icon ms-2 px-1 text-danger align-self-center" style="cursor: pointer;" data-bs-toggle="modal" onclick="$('#modal_remove_btn').attr('data-id','{{ $index }}')" data-bs-target="#remove_report_request_modal" title="Remove Report Request">
                            <i class="uil uil-times-circle"></i>
                        </a>
                        <form class="d-none" id="remove_report_request_{{ $index }}" action="{{ route('remove.report.request') }}" method="POST">@csrf <input type="hidden" name="email" value="{{$email}}" > </form>
                    </div>
                @empty
                    <div>
                        No Report Request Link Exists
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    
    <div wire:ignore.self class="modal fade" id="remove_report_request_modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row">
                        <div class="col-12">
                            <p class="fs-96 lh-1 mb-0">
                                <i class="uil uil-question-circle"></i>
                            </p>
                            <p>Are you sure you want to remove this report request link</p>
                            <button id="modal_remove_btn" data-id="" class="btn btn-sm btn-soft-red" onclick="$('#remove_report_request_'+($('#modal_remove_btn').attr('data-id'))).submit()" type="button">Yes</button>
                            <button class="btn btn-sm btn-soft-blue" type="button" data-bs-dismiss="modal" aria-label="Close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('data', {
                
            })
        });
    </script>
@endpush