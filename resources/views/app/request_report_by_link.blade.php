@extends('layouts.app')
@section('css')
<link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet" />
@livewireStyles
    <style>
    </style>
@endsection
@section('header')
    <section class="wrapper d-flex align-items-center hero_section_bg pt-16" style="">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <div class="post-header text-capitalize">
                        <h1 class="display-1 fs-42">Request Credit Report</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <livewire:request-report-by-link :data="$data" />
    
@endsection

@section('js')
<script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
<script>
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],

        [{ 'header': 1 }, { 'header': 2 }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],

        [{ 'size': ['small', false, 'large', 'huge'] }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],
        ['image', 'link'],
        ['clean']
    ];

    var editor = new Quill('#editor', {
        modules: { 
            toolbar: toolbarOptions,
         },
        placeholder: 'Enter the detailed description ...',
        theme: 'snow',
    });

    function linkHandler(value) {
      if (value) {
        var href = prompt('Enter the URL');
        this.quill.format('link', href);
      } else {
        this.quill.format('link', false);
      }
    }

    var toolbar = editor.getModule('toolbar');
    toolbar.addHandler('link', linkHandler);

    // $("#form_link_btn").click(function(e) {
    //     let form = e.target.getAttribute("href");
    //     $('html,body').animate({
    //             scrollTop: ($(form).offset().top - 61)
    //         },
    //         'slow');
    // });
</script>
@livewireScripts
@stack('scripts')
@endsection
