<!doctype html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="user-id" content="{{ Auth::user()->id }}">
    @endauth
    
    <x-css></x-css>
    <link rel="stylesheet" href="{{ asset('css/topbar.css') }}">

    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @yield('css')
</head>

<body>
    
    <x-topbar></x-topbar>
    <div class="content-wrapper bg-soft-ash">
        @yield('header')
        @yield('content')
    </div>
    <x-footer></x-footer>
    <x-toast></x-toast>
    
    <div class="modal fade" id="report_shareform_notification">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                    <h5 class="text-start">Share Report</h5>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <input name="credit_score_notification" id="credit_score_notification" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="credit_score_notification">Can View Credit Score</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="cash_flow_notification" id="cash_flow_notification" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="cash_flow_notification">Can View Cash Flow</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="expenses_notification" id="expenses_notification" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="expenses_notification">Can View Expenses</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="income_notification" id="income_notification" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="income_notification">Can View Income</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="email_check_notification" id="email_check_notification" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="email_check_notification" for="credit_score">Can View Email</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="contact_notification" id="contact_notification" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="contact_notification">Can View Contact #</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="initials_only_notification" id="initials_only_notification" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="initials_only_notification">Initials of the Name</label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input name="account_initials_only_notification" id="account_initials_only_notification" type="checkbox" class="p-1 mb-2 form-check-input">
                            <label class="form-check-label mb-2 fs-14 text-start" for="account_initials_only_notification">Initials of the Account Name</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <input name="user_id" type="hidden" id="user_id_notification">
                        <button id="addUserBtn_notification" type="button" class="btn btn-dark border-0 rounded-pill py-0 ms-3">
                            Share Report <i class="uil p-0 uil-user-plus text-white"></i>
                        </button>
                    </div>
                    <div class="text-start lh-1"><small id="report_notification_share_message" class="text-info"></small></div>
                    
                </div>
            </div>
        </div>
    </div>

    <audio id="notification_sound">
        <source src="{{ asset('audio/notification.mp3') }}">
    </audio>
    <x-js></x-js>
    @yield('js')
</body>
