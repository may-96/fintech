<section class="wrapper bg-soft-ash mb-2 mb-sm-20">
    <div class="container">
        <div class="col-lg-12 mb-15 align-items-center">
            <h2 class="fs-15 text-uppercase text-muted text-center mb-3">My Bank Account</h2>
            <h3 class="display-4 text-center">List of all the linked Accounts.</h3>
        </div>
        @forelse ($accounts as $key => $account)
            @php
                $institution = App\Models\Institution::find($key);
            @endphp
            <div class="post-category text-line @if (!$loop->first) mt-12 @endif">
                @if(App\Helpers\Functions::not_empty($institution)) <a href="#" class="hover" rel="category">{{ $institution->name }}</a> @endif
                @foreach ($account as $temp)
                    @if(App\Helpers\Functions::not_empty($temp))
                        @if ($loop->first)
                            <a class="remove_icon ms-2 px-1 text-danger" data-bs-toggle="modal" onclick="$('#modal_remove_btn').attr('data-id',{{ $temp['requisition_id'] }})" data-bs-target="#remove_bank_access_modal" title="Remove Account">
                                <i class="uil uil-times-circle"></i>
                            </a>
                            <form class="d-none" id="remove_bank_access_{{ $temp['requisition_id'] }}" action="{{ route('remove.bank', $temp['requisition_id']) }}" method="POST">@csrf</form>
                        @else
                            @break
                        @endif
                    @endif
                @endforeach
            </div>
            <!-- /.post-header -->
            <div class="row gy-4">
                @foreach ($account as $a)
                    @if(App\Helpers\Functions::not_empty($a))
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="card p-3 w-100">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between fs-16 fw-bold lh-1 mb-0">
                                        <span>@if (isset($a['iban'])) {{ $a['iban'] }} @elseif(isset($a['bban'])) {{ $a['bban'] }} @else {{ $a['resource_id'] }} @endif</span>
                                        <span>
                                            <a wire:click.prevent="get_sharing_info({{$a['id']}})" data-bs-toggle="modal" data-bs-target="#shareform" data-toggle="tooltip" data-placement="top" title="Share" class="share_icon fs-18"><i class="uil uil-share-alt"></i></a>
                                        </span>
                                    </div>
                                    <p class="mb-6 text-primary">@if (isset($a['owner_name'])) {{ $a['owner_name'] }} @else {{ $a['display_name'] }} @endif</p>
                                </div>
                                <div>
                                    @if (isset($a['account_name']))<p class="m-0 lh-1 fs-14">{{ $a['account_name'] }}</p>@endif
                                    <div class="clearfix">
                                        <small class="text-muted float-start">Currency: <span class="text-dark">{{ $a['currency'] }}</span></small>
                                        @if (isset($a['type_string']))<small class="text-muted float-end">Type: <span class="text-dark">{{ $a['type_string'] }}</span></small>@endif
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-2">
                                        @if(isset($share[$a['id']]) && $share[$a['id']]['count'] > 0)<small class="text-navy float-start">Shared With: <span class="text-share fw-bold">{{ $share[$a['id']]['count'] }} Users</span></small>@else<small></small>@endif
                                        <a class="btn small btn-sm btn-soft-ash rounded-pill px-4 py-0 float-end" href="{{ route('my.transactions', $a['account_id']) }}">View Transactions</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @empty
            <div class="row">
                <div class="col-12">
                    No accounts has yet been connected! Connected Accounts will appear here.
                </div>
            </div>
        @endforelse
    </div>
    @if(count($accounts) > 0)
        <div class="modal fade" id="remove_bank_access_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content text-center">
                    <div class="modal-body">
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="row">
                            <div class="col-12">
                                <p class="fs-96 lh-1 mb-0">
                                    <i class="uil uil-question-circle"></i>
                                </p>
                                <p>Are you sure you want to remove access to this bank</p>
                                <button id="modal_remove_btn" data-id="" class="btn btn-sm btn-soft-red" onclick="$('#remove_bank_access_'+($('#modal_remove_btn').attr('data-id'))).submit()" type="button">Yes</button>
                                <button class="btn btn-sm btn-soft-blue" type="button" data-bs-dismiss="modal" aria-label="Close">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="shareform">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                        <h5 class="text-start">Share with people</h5>
                        <div class="d-flex">
                            <input wire:model="email" type="email" id="textarea" class="p-1 form-control" placeholder="Email">
                            <button wire:click="add_shared_user" id="addUserBtn" type="button" class="btn btn-sm btn-dark border-0 rounded-pill py-0 ms-3">
                                <i class="uil p-0 uil-user-plus text-white"></i>
                            </button>
                        </div>
                        <div class="form-check">
                            <input wire:model="share_notes" type="checkbox" id="share_notes" class="p-1 form-check-input"> 
                            <label class="form-check-label text-start" for="share_notes">Share along with Transaction Notes</label>
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
                    </div>
                </div>
            </div>
        </div>
        @endif
</section>

@push('scripts')
    <script>
    </script>
@endpush
