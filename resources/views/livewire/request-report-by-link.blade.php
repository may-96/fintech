<div class="content-wrapper" x-data>
    <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
        <div id="form_area" class="container pt-10 pb-10 pt-md-14 text-center">
            {{-- <h2 class="h1 fs-46 mb-10 text-center mb-4">Request Report</h2> --}}
            <p class="mb-0">Enter Details below and share link to request a Credit Report.</p>
            
                <div class="mt-5 mb-3">
                    <div class="text-start input-group">
                        <input id="amount" wire:model.defer="amount" value="" type="number" min="0" name="amount" class="form-control rounded-0 px-2 py-1" placeholder="Amount to be Paid Per Month (Rent Amount, Mortgage Amount etc)" required>
                        
                        @php  @endphp
                        <select name="currency" wire:model.defer="currency" class="form-select rounded-0" placeholder="Select Currency" required>
                            <option disabled value="">Select Currency</option>

                            @foreach($currencies as $index => $currency)
                            <option value="{{$currency['code']}}" >{{ucwords($currency['currency'])}} - {{$currency['code']}}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    
                    
                </div>

                <div class="text-start bg-white form-floating" wire:ignore>
                    <div id="editor">{!! $details !!}</div>
                </div>
                
                <div>
                    <button class="btn btn-soft-primary rounded-pill mt-3 mx-1" x-on:click="$store.data.updateDetails()" type="button">{{$btn_txt}}</button>
                    @if($edit_mode == 1)<button class="btn btn-soft-orange rounded-pill mt-3 mx-1" wire:click="reset_fields()" type="button">End Editing</button>@endif
                </div>

                @if(App\Helpers\Functions::not_empty($error))<div class="text-start lh-1"><small class="text-danger">{{$error}}</small></div>@endif
                @if(App\Helpers\Functions::not_empty($success))<div class="text-start lh-1"><small class="text-success">{{$success}}</small></div>@endif

        </div>
        <div class="container">
            <div class="row"><h5>List of All Generated Links</h5></div>
            <div class="row ps-4">
                @forelse ($data as $index => $links)
                    <div class="col-12 mb-1 p-1 alert alert-primary d-flex justify-content-between">
                        <span class="ps-1 align-self-center">{{route('fetch.request.link.data',$links['link'])}}</span>
                        <div>
                        <a class="ms-2 px-1 text-warning align-self-center" style="cursor: pointer;" wire:click="edit_link_data('{{$links['link']}}')" title="Edit"><i class="uil uil-edit"></i></a>
                        <a class="remove_icon ms-2 px-1 text-danger align-self-center" style="cursor: pointer;" data-bs-toggle="modal" onclick="$('#modal_remove_btn').attr('data-id','{{ $links['id'] }}')" data-bs-target="#remove_report_request_modal" title="Remove Report Request Link">
                            <i class="uil uil-times-circle"></i>
                        </a>
                        </div>
                        {{-- <form class="d-none" id="remove_report_request_{{ $index }}" action="{{ route('remove.report.request') }}" method="POST">@csrf <input type="hidden" name="email" value="{{$email}}" > </form> --}}
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
                            <button id="modal_remove_btn" data-id="" class="btn btn-sm btn-soft-red" x-on:click="$store.data.delete_link" type="button" data-bs-dismiss="modal">Yes</button>
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
                details: "",
                updateDetails(){
                    @this.set('details',this.details);
                    @this.generateLink();
                    
                },
                setDetails(data){
                    this.details = data;
                },
                delete_link(){
                    let id = $('#modal_remove_btn').attr('data-id');
                    @this.deleteLink(id);
                }
            })
        });
        editor.on('text-change', function () {
            Alpine.store('data').setDetails(editor.root.innerHTML);
        });

        $(document).ready(function() {
            window.livewire.on('clearQuillContent', () => {
                editor.setContents([{ insert: '\n' }]);
                editor.root.dataset.placeholder = 'Enter the detailed description ...';
            });
            window.livewire.on('setQuillContent', () => {
                // editor.setContents([{ insert: @this.details }]);
                let delta = editor.clipboard.convert(@this.details);
                editor.setContents(delta, 'silent');
                editor.root.dataset.placeholder = '';
                Alpine.store('data').setDetails(@this.details);
                // editor.clipboard.dangerouslyPasteHTML(@this.details);
            });
        });
        
    </script>
@endpush