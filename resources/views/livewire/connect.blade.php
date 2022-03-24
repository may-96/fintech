<section>
    <section class="wrapper my-20" id="connect_form">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h4 class="mb-8">Connect your Bank Account using this Form Wizard</h4>
                </div>
            </div>
            <div class="row">

                <div class="col-12 mb-4">
                    <div class="card p-4">
                        <p class="d-block  fs-18 fw-bold">Select your country</p>

                        <div class="messages"></div>

                        <div>
                            <div class="form-select-wrapper" wire:ignore>
                                <select id="country_select" wire:model="country_code" class="custom_select form-select">
                                    <option data-placeholder="true">Please Select a Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->alpha_2_code }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div wire:loading wire:target="updateCountry">
                        <x-loading />
                    </div>
                </div>

                @if ($country_selected)
                    <div class="col-12 mb-4">
                        <div class="card p-4">
                            <p class="d-block  fs-18 fw-bold">Select your bank</p>

                            <div class="messages"></div>

                            <div>
                                <div class="form-select-wrapper" wire:ignore>
                                    <select id="bank_select" wire:model="bank_id " class="custom_select form-select">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div wire:loading.delay wire:target="updateBank">
                            <x-loading />
                        </div>
                    </div>
                @endif

                @if ($bank_selected)
                    <div x-show="{{ $bank_selected }}" class="col-12 mb-4">
                        <div class="card p-4">
                            <p class="d-block  fs-18 fw-bold">Agreement Details</p>

                            <div class="messages"></div>

                            <div class="row">
                                <div class="col-md-6 pe-md-4">
                                    <div class="form-floating mb-4">
                                        <input id="accessdays" name="accessdays" min="30" type="number" class="form-control" wire:model="access_valid_for_days" placeholder="select number of days" value="90" required>
                                        <label for="accessdays">Access Valid for Days *</label>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-md-4">
                                    <div class="form-floating">
                                        <input id="maxdays" name="maxdays" min="30" max="{{ $bank_ttd }}" type="number" class="form-control" wire:model="max_historical_days" placeholder="select no of days" value="{{$bank_ttd}}" required>
                                        <label for="maxdays">Max Data Historical Days *</label>
                                    </div>
                                    <div class="mb-4">
                                        <small class="text-info">Between 30 and {{$bank_ttd}}</small> - <small>Varies from Bank to Bank</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-check">
                                <input type="checkbox" class="form-check-input" checked="checked" id="balance" name="balance" wire:model="balances_access_scope" required>
                                <label class="form-check-label" for="balance">Bank Balance</label>
                            </div>

                            <div class="col-md-12 form-check">
                                <input type="checkbox" class="form-check-input" checked="checked" id="details" name="details" wire:model="details_access_scope" required>
                                <label class="form-check-label" for="details">Account Details</label>
                            </div>

                            <div class="col-md-12 form-check">
                                <input type="checkbox" class="form-check-input" checked="checked" id="transactions" name="transactions" disabled required>
                                <label class="form-check-label" for="transaction">Transaction Data</label>
                                <small class="text-info ms-2">Fetching Transaction Data is Compulsory for Generating Reports</small>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <input type="submit" id="createAgreement" wire:click="createAgreement" class="btn btn-primary rounded-pill btn-send" value="Create Agreement">
                                @if (trim($agreement_error_message) != '')<p class="text-danger fs-14 m-0">{{ $agreement_error_message }}</p>@endif
                                @if ($create_link == true)<p class="text-success fs-14 m-0">Agreement Created Successfully! Proceed to generating the Link for Bank Connection Authentication.</p>@endif
                            </div>
                        </div>
                        <div wire:loading.delay wire:target="createAgreement">
                            <x-loading />
                        </div>
                    </div>
                @endif

                @if ($create_link || $link_generated)
                    <div x-show="{{ $bank_selected }}" class="col-12 mb-4">
                        <div class="card p-4">
                            <p class="d-block  fs-18 fw-bold">Generate Link and Connect Bank</p>

                            <div class="messages"></div>

                            <div class="col-12 text-center">
                                @if ($create_link && !$link_generated)<button id="generateLink" wire:click="createLink" class="btn btn-primary rounded-pill btn-send" >Generate Link <x-loading wire:loading.delay wire:target="createLink" /></button>@endif
                                @if ($link_generated)
                                    <button id="authenticationLink" class="btn btn-primary rounded-pill btn-send" wire:click="redirectToLink"><span wire:loading.remove wire:target="redirectToLink">Connect Bank</span><span wire:loading wire:target="redirectToLink">Redirecting </span><x-loading wire:loading wire:target="redirectToLink" /></button>
                                    <p class="text-muted fs-14">You will be redirected to another page for authentication.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                @endif

            </div>
        </div>
    </section>
</section>

@push('scripts')
    <script>
        function formatSelect(state) {
            if (state.element?.dataset?.placeholder) {
                return state.text;
            }
            if (!state.id) {
                return state.text;
            }
            var $elem = state.text;
            if (state.element?.dataset?.logo) {
                $elem = $('<span><img src="' + state.element.dataset.logo + '" class="img-flag" /> ' + state.text + '</span>');
            } else {
                var baseUrl = "/images/countries/";
                var $elem = $('<span><img src="' + baseUrl + '/' + (state.text.toLowerCase()).replace(' ', '_') + '.png" class="img-flag" /> ' + state.text + '</span>');
            }
            return $elem;
        };

        function init_country_select2() {
            $('#country_select').select2({
                width: '100%',
                templateResult: formatSelect,
                templateSelection: formatSelect,
            });

            $('#country_select').on('change', async () => {
                let data = $('#country_select').select2("val");
                let selected = $('#country_select').select2("data");
                @this.set('country_code', data);
                @this.set('country_name', selected[0].text);
                await @this.updateCountry();

                let bank_elem = $('#bank_select');
                if (bank_elem.hasClass('.select2-offscreen')) {
                    bank_elem.select2('destroy');
                }
                bank_elem.empty();
                bank_elem.off('change');
                bank_elem.append($("<option></option>").attr("data-placeholder", true).text("Please Select a Bank"));
                let bank_data = @this.banks;
                $.each(bank_data, function(index, value) {
                    bank_elem.append($("<option></option>").attr("value", value.id).attr("data-logo", value.logo).attr("data-bic", value.bic).attr("data-ttd", value.transaction_total_days).text(value.name));
                });
                bank_elem.select2({
                    width: '100%',
                    templateResult: formatSelect,
                    templateSelection: formatSelect,
                });
                bank_elem.on('change', () => {
                    let data = bank_elem.select2("val");
                    let selected = bank_elem.select2("data");
                    @this.set('bank_id', data);
                    @this.set('bank_name', selected[0].text);
                    @this.set('bank_logo', selected[0].element.dataset.logo);
                    @this.set('bank_ttd', selected[0].element.dataset.ttd);
                    @this.set('bank_bic', selected[0].element.dataset.bic);
                    @this.updateBank();
                });
            });
        }

        $(document).ready(function() {
            init_country_select2();
            window.livewire.on('processConnectLink', () => {
                window.location.href = @this.requisition_link;
            });
        });
    </script>
@endpush
