<section class="wrapper bg-soft-ash mb-2 mb-sm-20">
    <div class="container">
        <div class="col-lg-12 mb-15 align-items-center">
            <h2 class="display-4 mb-3 text-center">Shared Accounts</h2>
            <p class="lead fs-lg mb-10 text-center px-md-16 px-lg-21 px-xl-0">List of the Bank Accounts that are shared with you.</p>
        </div>

        {{-- <div class="post-category text-line">
            <a href="#" class="hover" rel="category">User Name</a>
        </div> --}}

        <div class="row gy-4">
            @forelse ($accounts as $a)
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="card p-3 w-100">
                        <div>
                            <div class="d-flex text-primary align-items-center justify-content-between fs-16 fw-bold lh-1 mb-2">
                                <span>@if (App\Helpers\Functions::not_empty($a['pivot']['nickname'])){{ $a['pivot']['nickname'] }} @else <small style="font-style: italic;">Account Nickname will appear here</small> @endif</span>
                                <span>
                                    <a wire:click.prevent="add_nickname({{ $a['id'] }})" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#nickname_modal" class="share_icon fs-18" title="Add Nickname">
                                        <i class="uil uil-edit"></i>
                                    </a>
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between fs-16 fw-bold lh-1 mb-2">
                                {{ App\Models\Account::find($a['id'])->institution->name }}
                            </div>
                            <div class="d-flex align-items-center justify-content-between fs-14 lh-1 mb-0">
                                <span>@if (isset($a['iban'])) {{ $a['iban'] }} @elseif(isset($a['bban'])) {{ $a['bban'] }} @else {{ $a['resource_id'] }} @endif</span>
                            </div>
                            <p class="mb-0 fs-14 text-warning">@if (isset($a['owner_name'])) {{ $a['owner_name'] }} @elseif(isset($a['account_name'])) {{ $a['account_name'] }} @else {{ $a['display_name'] }} @endif</p>
                        </div>
                        <div>
                            <div class="clearfix">
                                <small class="text-muted">Currency: <span class="text-dark">{{ $a['currency'] }}</span></small>
                            </div>
                            <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center mt-2">
                                <a class="btn small btn-sm btn-soft-ash rounded-pill px-4 py-0 float-end" href="{{ route('shared.transactions', $a['account_id']).'-'.$a['id'] }}">View Transactions</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    No accounts has been shared with you.
                </div>
            @endforelse

        </div>
    </div>
    @if (count($accounts) > 0)
        <div wire:ignore.self class="modal fade" id="nickname_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">
                    <div class="modal-body">
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                        <h5 class="text-start">Add Account Nickname</h5>
                        <div class="d-flex">
                            <input wire:keydown.enter="save_nickname" wire:model="nickname" type="text" class="p-1 form-control" placeholder="Nickname">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

@push('scripts')
    <script>
        $(document).ready(function() {
            window.livewire.on('nickNameAdded', () => {
                let myModalEl = document.getElementById('nickname_modal');
                let modal = bootstrap.Modal.getInstance(myModalEl);
                modal.hide();
            })
        });
    </script>
@endpush
