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
            <form class="contact-form needs-validation" method="post" action="" novalidate>
                <div class="messages"></div>
                <div class="row gx-4">
                    <div class="col-md-6">
                        <div class="form-floating mb-4">
                            <input id="form_name" type="text" name="name" class="form-control" placeholder="Jane" required>
                            <label for="form_name">First Name *</label>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please enter your first name.
                            </div>
                        </div>
                    </div>
                    <!-- /column -->
                    <div class="col-md-6">
                        <div class="form-floating mb-4">
                            <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Doe" required>
                            <label for="form_lastname">Last Name *</label>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please enter your last name.
                            </div>
                        </div>
                    </div>
                    <!-- /column -->
                    <div class="col-md-6">
                        <div class="form-floating mb-4">
                            <input id="form_email" type="email" name="email" class="form-control" placeholder="jane.doe@example.com" required>
                            <label for="form_email">Email *</label>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                    </div>
                    <!-- /column -->
                    <div class="col-md-6">
                        <div class="form-select-wrapper">
                            <select class="form-select" id="form-select" required>
                                <option selected disabled value="">Select a department</option>
                                <option value="1">Sales</option>
                                <option value="2">Marketing</option>
                                <option value="3">Customer Support</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select a department.
                            </div>
                        </div>
                    </div>
                    <!-- /column -->
                    <div class="col-12">
                        <div class="form-floating mb-4">
                            <textarea id="form_message" name="message" class="form-control" placeholder="Your message" style="height: 150px" required></textarea>
                            <label for="form_message">Message *</label>
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
                        <input type="submit" class="btn btn-primary rounded-pill btn-send mb-3" value="Send message">
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
@endsection
