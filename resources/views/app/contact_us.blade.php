@extends('layouts.app')
@section('css')
@endsection
@section('content')
    <section class="wrapper">
        <div class="container pb-11">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <h2 class="display-4 mb-3 mt-20 text-center">Drop Us a Line</h2>
                    <p class="lead text-center mb-10">Reach out to us from our contact form and we will get back to you shortly.</p>
                    <form class="contact-form needs-validation" id="contact_form" method="post" action="{{route('submit.contact.query')}}" novalidate>
                        @csrf
                        <div class="messages"></div>
                        <div class="row gx-4">
                            <div class="col-md-6">
                                <div class="form-floating mb-4">
                                    <input id="full_name" type="text" value="{{old('full_name')}}" name="full_name" class="form-control" placeholder="Jane Doe" required>
                                    <label for="full_name">Full Name *</label>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your Full Name.
                                    </div>
                                </div>
                            </div>
                            <!-- /column -->
                            
                            <!-- /column -->
                            <div class="col-md-6">
                                <div class="form-floating mb-4">
                                    <input id="email_address" type="email" value="{{old('email_address')}}" name="email_address" class="form-control" placeholder="jane.doe@example.com" required>
                                    <label for="email_address">Email *</label>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please provide a valid Email Address.
                                    </div>
                                </div>
                            </div>
                            <!-- /column -->
                            <div class="col-md-12">
                                <div class="form-floating mb-4">
                                    <input id="subject" type="text" value="{{old('subject')}}" name="subject" class="form-control" placeholder="..." required>
                                    <label for="subject">Subject *</label>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter a Subject Title
                                    </div>
                                </div>
                            </div>
                            <!-- /column -->
                            <div class="col-12">
                                <div class="form-floating mb-4">
                                    <textarea id="message" name="message" class="form-control" placeholder="Your Message" style="height: 150px" required>{{old('message')}}</textarea>
                                    <label for="message">Message *</label>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your messsage.
                                    </div>
                                </div>
                            </div>
                            <!-- /column -->
                            <div class="col-12 text-center">
                                <button class="g-recaptcha btn btn-primary rounded-pill btn-send mb-3" data-sitekey="{{env('GOOGLE_RECAPTCHA_V3_SITE_KEY')}}" data-callback='onSubmit' data-action='submit'>Send Message</button>
                                {{-- <input type="submit" class="btn btn-primary rounded-pill btn-send mb-3" value="Send Message"> --}}
                                <p class="text-muted"><strong>*</strong> These fields are required.</p>
                            </div>
                            <!-- /column -->
                        </div>
                        <!-- /.row -->
                    </form>
                    <!-- /form -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection
@section('js')
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("contact_form").submit();
        }
    </script>
@endsection
