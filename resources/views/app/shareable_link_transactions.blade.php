@extends('layouts.app')
@section('css')
@livewireStyles
<style>
    .note_textarea {
            /* resize: none;
            height: 28px; */
        }
        .note_para,
        .note_textarea {
            line-height: 1.3;
            background: #f9f9f9;
            border: 1px solid #dfe3e7;
            white-space: pre-wrap;
        }
        .note_textarea_timeline {
            
        }
        
        .comment_btn{
            cursor: pointer;
        }

        .timeline_date {}
        .timeline_date::before {
            content: "\A";
            position: absolute;
            left: -1.25rem;
            top: 0.25rem;
            display: inline-block;
            background: #343f52;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            margin-top: 1.5rem;
        }

        .timeline_date_2 {
            background: #f2f5fa;
        }
        .timeline_date_2::before {
            content: "\A";
            position: absolute;
            margin-top: 0.45rem;
            margin-left: 0.25rem;
            display: inline-block;
            background: #343f52;
            border-radius: 50%;
            width: 8px;
            height: 8px;
        }
        
        .timeline_transaction {}
        .timeline_transaction::before {
            content: "";
            position: absolute;
            left: -1rem;
            border-left: 2px solid #aab0bc;
            height: 100%;
            height: -webkit-fill-available;
            height: -moz-available;
            height: fill-available;
        }
        .transaction_danger {}
        .transaction_success {}
        .timeline_details {}
        .transaction_success.timeline_details::before,
        .transaction_danger.timeline_details::before {
            left: -1rem;
            content: "\A";
            position: absolute;
            width: 20px;
            height: 3px;
            margin-top: 0.65rem;
        }
        .transaction_success.timeline_details::before {
            background: #6fc0a5;
        }
        .transaction_danger.timeline_details::before {
            background: #e2626b;
        }
        .transaction_neutral.timeline_details::before {
            background: #343f52;
        }
        .lh1_3 {
            line-height: 1.3 !important;
        }
        .timeline_year_wrapper::before {
            content: attr(data-before-content);

        }
        .timeline_navigation{
            top: 65px;
            position: sticky;
            font-family: monospace !important;
        }
        .year_links{
            font-family: monospace !important;
        }
        .year_links:hover{
            color: #3f78e0 !important;
        }
        .timeline_content_holder{
            /* max-height: 750px;
            overflow-y: auto; */
        }
        .timeline_content_holder::-webkit-scrollbar {
            width: 0;  /* Remove scrollbar space */
            background: transparent;  /* Optional: just make scrollbar invisible */
        }
        .timeline_content_holder::-webkit-scrollbar-thumb {
            background: #FF0000;
        }
        .big_border_left{
            border-left: 6px solid;
        }
        .big_border_bottom{
            border-bottom: 4px solid;
        }
</style>
@endsection
@section('header')
    <section class="wrapper vh-100 d-flex align-items-center hero_section_bg" style="background-image: url({{asset('images/background/Hexagon.svg')}})">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <div class="post-header text-capitalize">
                        <h1 class="display-1 fs-66 mb-4">View Transaction</h1>
                        <p class="lead fs-23 lh-sm text-indigo animated-caption"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <livewire:shareable-link-transactions :account_id="$account_id" :aid="$aid" :notes_shared="$notes_shared" />
@endsection

@section('js')
    <script src="{{asset('js/save_transactions.js')}}"></script>
    @livewireScripts
    <script src="{{ asset('js/alpine.js') }}"></script>
    @stack('scripts')
@endsection
