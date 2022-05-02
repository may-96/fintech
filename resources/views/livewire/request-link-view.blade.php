<div class="content-wrapper ">

    
    
    <section class="wrapper">
        <div class="container pb-10">
            <div class="card">
                <div class="card-header px-5 p-3 fw-bold fs-18">Details</div>
                <div class="card-body px-5 p-3">
                    <p>
                        Amount to be paid per Month: <strong>{{ $data->currency }} {{ $data->amount }}</strong>
                    </p>
                    <pre style="white-space: pre-wrap; font-family: Manrope, sans-serif; padding: 0; line-height: 1.3;">{!! nl2br($data->details) !!}</pre>
                </div>
            </div>
        </div>
    </section>

    <section class="wrapper">
        <div class="container pb-10">
            <div class="card py-12 bg-white">
                <div class="row text-center">
                    <div class="col-md-10 mx-auto">
                        <h2 class="fs-24 text-uppercase text-muted mb-3">How it Works</h2>
                        <h3 class="fs-16">Share Your Credit Report in Few Easy Steps</h3>
                    </div>
                </div>
                <div class="row bg-white gy-8 text-center m-auto">
                    <div class="col-lg-4">
                        <div class="icon btn btn-block btn-lg btn-soft-yellow mb-5">
                            <i class="uil uil-sign-in-alt"></i>
                        </div>
                        <h4>Login/Register</h4>
                        <p class="mb-3">Login to your Account or Register a new Account via simple and user friendly form.</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="icon btn btn-block btn-lg btn-soft-green mb-5">
                            <i class="uil uil-cloud-data-connection"></i>
                        </div>
                        <h4>Connect Bank</h4>
                        <p class="mb-3">Connect your bank account in few clicks. You just have to choose your country and bank that's it.</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="icon btn btn-block btn-lg btn-soft-blue mb-5">
                            <i class="uil uil-share-alt"></i>
                        </div>
                        <h4>Share Report</h4>
                        <p class="mb-3">After your bank details are fetched your can share your credit report by just one click.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @guest
        <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30">
            <div id="form_area" class="container pb-10 text-center">
                <h2 class="h1 fs-36 mb-3 text-center mb-4">Login/Register</h2>
                <p>Please login or register your account to share the report. After registration you have to connect your bank account as well.</p>
                <div>
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab" aria-controls="pills-register" aria-selected="true">Register</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-login" aria-selected="false">Login</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
                            <div class="col-12 align-self-center">
                                <form method="POST" id="register_form" action="{{ route('register') }}" class="m-auto" style="max-width: 25rem;">
                                    @csrf
                                    <!-- Email input -->
                                    <div class="text-dark fs-24 lh-1 fw-bold text-upper text-center mb-6">Create an Account</div>
                                    <div class="form-outline mb-4 row">
                                        <div class="col-sm-6">
                                            <input type="text" id="fname" name="fname" required value="{{ old('fname') }}" placeholder="First Name" autocomplete="given-name" class="form-control @error('fname') is-invalid @enderror" />
                                            @error('fname')
                                                <span class="invalid-feedback text-start" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" id="lname" name="lname" required value="{{ old('lname') }}" placeholder="Last Name" autocomplete="family-name" class="form-control @error('lname') is-invalid @enderror" />
                                            @error('lname')
                                                <span class="invalid-feedback text-start" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                
                                    <div class="form-outline mb-4">
                                        <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="Email Address" autocomplete="email" class="form-control @error('email') is-invalid @enderror" />
                                        @error('email')
                                            <span class="invalid-feedback text-start" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                
                                    <!-- Password input -->
                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" required placeholder="New Password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" />
                                        @error('password')
                                            <span class="invalid-feedback text-start" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                
                                    <div class="form-outline mb-1">
                                        <input type="password" id="password_confirmation" required name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" />
                                    </div>
                
                                    <div class="mt-4 mb-2 text-start">
                                        <input type="checkbox" id="terms" name="terms" required class="form-check-input @error('terms') is-invalid @enderror" />
                                        <label for="terms" class="text-muted ms-2 fs-14">I agree, to your <a href="#" target="_blank" class="fst-normal">Terms</a>, <a href="#" target="_blank" class="fst-normal">Privacy Policy</a> and <a href="#" target="_blank" class="fst-normal">Cookie Policy</a></label>
                                        @error('terms')
                                            <span class="invalid-feedback text-start" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                
                                    <!-- Submit button -->
                                    <button type="submit" id="action_btn" class="btn btn-purple col-12">Sign up <x-loading id="register_loader" class="d-none" /></button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
                            <div class="col-12 align-self-center">
                                <form class="m-auto" style="max-width: 25rem;" id="login_form" method="POST" action="{{route('login')}}">
                                    @csrf
                                    <!-- Email input -->
                                    <div class="text-dark fs-24 lh-1 fw-bold text-upper text-center mb-6">Access Your Account</div>
                                    <div class="form-outline mb-4">
                                        <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="Email Address" autocomplete="email" class="form-control @error('email') is-invalid @enderror" />
                                        @error('email')
                                            <span class="invalid-feedback text-start" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                
                                    <!-- Password input -->
                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" required placeholder="Password" autocomplete="password" class="form-control @error('password') is-invalid @enderror" />
                                        @error('password')
                                            <span class="invalid-feedback text-start" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <!-- Checkbox -->
                                        <div class="form-check">
                                            <input type="checkbox" id="remember" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }} />
                                            <label class="form-check-label" for="remember">Remember Me</label>
                                        </div>
                
                                    </div>
                
                                    <!-- Submit button -->
                                    <button type="submit" id="action_btn" class="btn btn-purple col-12">Login <x-loading id="login_loader" class="d-none" /></button>
                
                                    <div class="text-end mt-2"><a href="{{route('password.request')}}">Forgot password?</a></div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </section>
    @endguest

    @auth
        @if(auth()->user()->accounts()->count() > 0)
        <section class="wrapper pb-lg-15 pb-md-20 pb-sm-30 ">
            <div id="form_area" class="container pb-10">
                <h2 class="h1 fs-36 mb-3 text-center mb-4">Share Report</h2>
                <p class="mb-4 text-center">Select things you want to share in the report.</p>
                <form action="{{route('report.grant.access.link')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                            <input name="credit_score" id="credit_score" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="credit_score">Can View Credit Score</label>
                        </div>
                        <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                            <input name="cash_flow" id="cash_flow" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="cash_flow">Can View Cash Flow</label>
                        </div>
                        <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                            <input name="expenses" id="expenses" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="expenses">Can View Expenses</label>
                        </div>
                        <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                            <input name="income" id="income" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="income">Can View Income</label>
                        </div>
                        <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                            <input name="email_check" id="email_check" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="email_check">Can View Email</label>
                        </div>
                        <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                            <input name="contact" id="contact" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="contact">Can View Contact #</label>
                        </div>
                        <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                            <input name="initials_only" id="initials_only" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="initials_only">Initials of the Name</label>
                        </div>
                        <div class="col-12 offset-sm-1 col-sm-5 offset-md-2 col-md-4">
                            <input name="account_initials_only" id="account_initials_only" type="checkbox" class="p-1 mb-2 form-check-input" checked>
                            <label class="form-check-label mb-2 fs-14 text-start" for="account_initials_only">Initials of the Account Name</label>
                        </div>
                        <input type="hidden" value="{{$data->link}}" name="link">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-soft-primary rounded-pill" type="submit">Share Report</button>
                    </div>
                </form>

            </div>
        </section>
        @else
        <section class="wrapper text-center pb-lg-15 pb-md-20 pb-sm-30">
            <div id="form_area" class="container pb-10 text-center">
                <h2 class="h1 fs-36 mb-3 text-center mb-4">Connect Bank</h2>
                <p>Please connect your bank account to share your credit report.</p>
                
                <section class="wrapper" id="connect_form">
                    <div class="container">
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

                            @if ($link_generated)
                                <div x-show="{{ $bank_selected }}" class="col-12 mb-4">
                                    <div class="card p-4">
                                        <p class="d-block  fs-18 fw-bold">Process Bank Connection</p>

                                        <div class="messages"></div>

                                        <div class="col-12 text-center">
                                            <button id="authenticationLink" class="btn btn-primary rounded-pill btn-send" wire:click="redirectToLink"><span wire:loading.remove wire:target="redirectToLink">Connect Bank</span><span wire:loading wire:target="redirectToLink">Redirecting </span><x-loading wire:loading wire:target="redirectToLink" /></button>
                                            <p class="text-muted fs-14">You will be redirected to another page for authentication.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </section>
            </div>
        </section>
        @endif
    @endauth

</div>

@push('scripts')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('data', {
                
            })
        });

        $('#register_form').on('submit', () => {
            document.querySelector('#register_loader').classList.remove('d-none');
            document.querySelector('#register_loader').classList.add('d-inline-block');
        });

        $('#login_form').on('submit', () => {
            document.querySelector('#login_loader').classList.remove('d-none');
            document.querySelector('#login_loader').classList.add('d-inline-block');
        });

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

        function updateBanks(){
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
        }

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

                updateBanks();
            });
        }

        function ip_based(){
            let ip_based = @this.ip_based;
            if(ip_based){
                updateBanks();
            }
        }

        $(document).ready(function() {
            init_country_select2();
            ip_based();
            
            window.livewire.on('processConnectLink', () => {
                window.location.href = @this.requisition_link;
            });

        });
        
    </script>
@endpush