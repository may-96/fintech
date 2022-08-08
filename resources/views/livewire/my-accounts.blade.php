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
                    @if(App\Helpers\Functions::not_empty($a) && isset($a['requisition']))
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="card p-3 w-100">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between fs-16 fw-bold lh-1 mb-0">
                                        <span>@if (isset($a['iban'])) {{ $a['iban'] }} @elseif(isset($a['bban'])) {{ $a['bban'] }} @else {{ $a['resource_id'] }} @endif</span>
                                        <span>
                                            <a wire:click.prevent="get_sharing_info({{$a['id']}})" data-bs-toggle="modal" data-bs-target="#shareform" data-toggle="tooltip" data-placement="top" title="Share" class="share_icon fs-18"><i class="uil uil-share-alt"></i></a>
                                        </span>
                                    </div>
                                    <p class="mb-0 text-primary">@if (isset($a['owner_name'])) {{ $a['owner_name'] }} @else {{ $a['display_name'] }} @endif</p>
                                    <small class="mb-6 d-block text-muted"> @if (isset($a['full_name'])) {{ $a['full_name'] }} @endif </small>
                                </div>
                                <div>
                                    @if (isset($a['account_name']) || isset($a['account_status']))<p class="m-0 lh-1 fs-14">{{ $a['account_name'] }} @if (isset($a['account_status']))<span class="@if($a['account_status'] == 'EXPIRED' || ($a['requisition']['status_long'] == 'EXPIRED' || $a['requisition']['status_long'] == 'SUSPENDED')) text-danger @else text-info @endif ">(@if($a['account_status'] == 'EXPIRED' || $a['requisition']['status_long'] == 'EXPIRED') EXPIRED @elseif($a['requisition']['status_long'] == 'SUSPENDED') SUSPENDED @else {{ $a['account_status'] }} @endif)</span>@endif </p>@endif
                                    <div class="clearfix">
                                        <small class="text-muted float-start">Currency: <span class="text-dark">{{ $a['currency'] }}</span></small>
                                        @if (isset($a['type_string']))<small class="text-muted float-end">Type: <span class="text-dark">{{ $a['type_string'] }}</span></small>@endif
                                    </div>
                                    @if (isset($a['credit_score']) && App\Helpers\Functions::not_empty($a['credit_score']))
                                    <div class="clearfix fw-bold my-1">
                                        <small class="text-muted float-start">Credit Score: <span class="text-dark ">{{ $a['credit_score'] }}</span></small>
                                    </div>
                                    @endif
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-2">
                                        @if(isset($share[$a['id']]) && $share[$a['id']]['count'] > 0)<small class="text-navy mt-1">Shared With: <span class="text-share fw-bold">{{ $share[$a['id']]['count'] }} Users</span></small>@else<small></small>@endif
                                        <span class="text-center">
                                            @if($a['account_status'] == 'EXPIRED' || ($a['requisition']['status_long'] == 'EXPIRED' || $a['requisition']['status_long'] == 'SUSPENDED'))
                                                <a class="btn small btn-sm btn-soft-red rounded-pill px-2 py-0 mt-1" data-bs-toggle="modal" onclick="@this.set('reconnect_requisition_id',{{ $a['requisition']['id'] }}); @this.set('reconnect_error','')" data-bs-target="#reconnect_bank_modal" title="Reconnect Account">Reconnect</a>
                                            @else
                                                @php
                                                    $agreement = App\Models\Agreement::find($a['requisition']['id']);
                                                    $reconnect_cond = false;
                                                    if(App\Helpers\Functions::not_empty($agreement)){
                                                        $ag_date = Carbon\Carbon::parse($agreement->agreement_date);
                                                        $now = Carbon\Carbon::now();
                                                        $valid_for = (int) $agreement->access_valid_for_days;
                                                        if($now->diffInDays($ag_date) > ($valid_for - 4)){
                                                            $reconnect_cond = true;
                                                        }
                                                    }
                                                @endphp

                                                @if($reconnect_cond == true)
                                                    <a class="btn small btn-sm btn-soft-red rounded-pill px-2 py-0 mt-1" data-bs-toggle="modal" onclick="@this.set('reconnect_requisition_id',{{ $a['requisition']['id'] }}); @this.set('reconnect_error','')" data-bs-target="#reconnect_bank_modal" title="Reconnect Account">Reconnect</a>
                                                @endif
                                                
                                                <a class="btn small btn-sm btn-soft-ash rounded-pill px-2 py-0 mt-1" href="{{ route('my.transactions', $a['account_id']).'-'.$a['id'] }}">View Transactions</a>
                                                
                                            @endif                                            
                                        </span> 
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
        <div wire:ignore.self class="modal fade" id="reconnect_bank_modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content text-center">
                    <div class="modal-body">
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="row">
                            <div class="col-12">
                                <p class="fs-96 lh-1 mb-0">
                                    <i class="uil uil-question-circle"></i>
                                </p>
                                <h5>Reconnect Bank</h5>
                                <p>You will be redirected to a new page.</p>
                                
                                @if($reconnect_status == 0)
                                <div id="loading_bars" class="d-flex mb-4 align-items-center justify-content-center">
                                    <x-loading />
                                    Creating Agreement and Requisition before Redirection. Please wait ...
                                </div>
                                @endif

                                @if($reconnect_error != "" && $reconnect_status == -1)
                                <div class="alert alert-danger alert-icon" role="alert">
                                    <i class="uil uil-times-circle"></i> {{$reconnect_error}}
                                </div>
                                @endif

                                @if($reconnect_status != 0)
                                <button id="modal_reconnect_btn" data-id="" class="btn btn-sm btn-soft-blue mt-2" wire:click="reconnect" type="button">Initiate Reconnection</button>
                                <button class="btn btn-sm btn-soft-red mt-2" type="button" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                @endif
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
        @endif
        
</section>

@push('scripts')
    <script>
        function copy_text() {
            var copyText = document.getElementById("shareable_link").innerHTML;
            var copy = document.getElementById("copyTextarea");
            copy.value = copyText;
            copy.focus();
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
        $(document).ready(function() {
            window.livewire.on('processReconnectLink', (link) => {
                window.location.href = link;
            });
        });
    </script>
@endpush
