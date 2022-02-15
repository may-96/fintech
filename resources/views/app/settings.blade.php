@extends('layouts.app')
@section('css')
@endsection
@section('content')


    <section class="wrapper mt-15">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-10 d-flex">

                    <img src="{{asset('images/icons/settings-2.svg')}}" class="svg-inject icon-svg text-primary" alt="" />
                    <h1 class="ms-2 mt-4 underline">Settings</h1>
                </div>
                <div class="col-8 align-items-center pb-4">

                    <form method="post" action="" class="validate">
                    <div class="card flex-row p-4 d-flex mb-5 justify-content-start justify-content-md-around">

                        <div class="col-12">
                            <div>
                                <h1>Basic info</h1>
                                <p class="text-muted">Edit your basic profile settings</p>
                            </div>
                            <div>
                                <ul class="list-group ms-0">
                                    <li class="list-group-item d-flex justify-content-between">
                                        Name
                                        <div id="field-1" class="form-floating mb-4 d-block">
                                            <input id="form_name" type="text" name="name" class="form-control" placeholder="Jane" required>
                                            <label for="form_name">Full Name *</label>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter your first name.
                                            </div>
                                        </div>
                                        <span class="fs-18 d-none" id="val-1">Shahzad khan</span>
                                        <a href="#" id="edit-1" onclick="showhide(1)"><i class="uil uil-pen"></i></a>
                                        <a href="#" id="save-1" onclick="showhide(1)"><i class="uil uil-pen"></i></a>
                                    </li>
                                    <hr class="my-0" />
                                    <li class="list-group-item d-flex justify-content-between">
                                        Birth
                                        <div id="field-2" class="form-select-wrapper d-flex">


                                            <input id="form_name" type="date" name="name" class="form-control" placeholder="year" required>
                                        </div>
                                        <span class="fs-18 d-none" id="val-2"> 15 july, 1990</span>

                                        <a href="#" id="edit-2"><i class="uil uil-pen"></i></a>
                                        <a href="#" id="save-2"><i class="uil uil-pen"></i></a>

                                    </li>
                                    <hr class="my-0" />
                                    <li class="list-group-item d-flex justify-content-between">
                                        Gender
                                        <div class="me-2">
                                            <input class="form-check-input" type="radio" name="gender" id="male">
                                            <label class="form-check-label" for="male">
                                                Male
                                            </label>

                                            <input class="form-check-input" type="radio" name="gender" id="female">
                                            <label class="form-check-label" for="female">
                                                Female
                                            </label>


                                        </div>
                                        <span class="fs-18" id="val-3"></span>
                                        <a href="#"><i id="edit-3" class="uil uil-pen"></i></a>
                                        <a href="#"><i id="save-3" class="uil uil-pen"></i></a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div></form>

                    <div class="card flex-row p-4 d-flex justify-content-start justify-content-md-around">
                        <div class="col-12">
                            <div>
                                <h1>Contact info</h1>
                                <p class="text-muted">Edit your Contact settings</p>
                            </div>
                            <div>
                                <ul class="list-group ms-0">
                                    <li class="list-group-item d-flex justify-content-between">
                                        Email
                                        <span class="fs-18"> Shahzadcaan7@gmail.com</span>
                                        <a href="#" onclick="showhide(1)"><i class="uil uil-pen"></i></a>
                                    </li>
                                    <hr class="my-0" />
                                    <li class="list-group-item d-flex justify-content-between">
                                        Phone No
                                        <span class="fs-18"> 090078601</span>
                                        <a href="#"><i class="uil uil-pen"></i></a>
                                    </li>
                                    <hr class="my-0" />

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div></section>
@endsection
@section('js')

    <script src="{{asset('js/settings.js')}}"></script>
@endsection
