@extends('layouts.app')
@section('css')
    <style>
        .field-width{
            width: auto;
        }
    </style>
@endsection
@section('content')


    <section class="wrapper mt-15">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-10 d-flex">
                    <img src="{{asset('images/icons/settings-2.svg')}}" class="svg-inject icon-svg text-primary" alt="" />
                    <h1 class="ms-2 mt-4 underline">Settings</h1>
                </div>
                <div class="col-sm-12 col-md-8 align-items-center pb-4">

                    <form method="post" action="{{route('basic.settings')}}" class="validate">
                        @csrf
                        <div class="card p-4 mb-5">
                            <div class="col-12">
                                <div>
                                    <h1>Basic info</h1>
                                    <p class="text-muted">Edit your basic profile settings</p>
                                </div>
                                <div>
                                    <ul class="list-group ps-0">
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">First Name</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input id="fname" type="text" value="{{old('fname', $user->fname)}}" name="fname" class="form-control px-2 py-1 border border-secondary @error('fname') is-invalid @enderror" placeholder="Jane" required>
                                                @error('fname')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                        <hr class="my-0" />
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Last Name</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input id="lname" type="text" value="{{old('lname', $user->lname)}}" name="lname" class="form-control px-2 py-1 border border-secondary @error('lname') is-invalid @enderror" placeholder="Doe" required="">
                                                @error('lname')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                        <hr class="my-0" />
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Company</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input id="company" type="text" value="{{old('company', $user->company)}}" name="company" class="form-control px-2 py-1 border border-secondary @error('company') is-invalid @enderror" placeholder="Doe" required="">
                                                @error('company')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                        <hr class="my-0" />
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Date of Birth</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input id="dob" type="date" value="{{old('dob', $user->dob)}}" name="dob" class="form-control px-2 py-1 border border-secondary @error('dob') is-invalid @enderror" placeholder="Date of Birth" >
                                                @error('dob')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                        <hr class="my-0" />
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Gender</span>
                                            <div class="col-8 d-inline-block">
                                                <div><input class="form-check-input" type="radio" name="gender" id="male" value="male" @if(old('gender', $user->gender) == 'male') checked @endif>
                                                <label class="form-check-label" for="male">Male</label></div>
                                                <div><input class="form-check-input" type="radio" name="gender" id="female" value="female" @if(old('gender', $user->gender) == 'female') checked @endif>
                                                <label class="form-check-label" for="female">Female</label></div>
                                                <div><input class="form-check-input" type="radio" name="gender" id="other" value="other" @if(old('gender', $user->gender) == 'other') checked @endif>
                                                <label class="form-check-label" for="other">Other</label></div>
                                                @error('gender')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-end"><button type="submit" class="btn btn-sm btn-primary">Save</button></div>
                        </div>
                    </form>

                    <form method="post" action="{{route('contact.settings')}}" class="validate">
                        @csrf
                        <div class="card p-4 mb-5">
                            <div class="col-12">
                                <div>
                                    <h1>Contact info</h1>
                                    <p class="text-muted">Edit your contact settings</p>
                                </div>
                                <div>
                                    <ul class="list-group ps-0">
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Email</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input type="email" value="{{$user->email}}" disabled class="form-control disabled px-2 py-1 border border-secondary">

                                            </div>
                                        </li>
                                        <hr class="my-0" />
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Phone #</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input id="contact" type="tel" value="{{old('contact', $user->contact)}}" name="contact" class="form-control px-2 py-1 border border-secondary @error('contact') is-invalid @enderror" placeholder="090078601">
                                                @error('contact')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                        <hr class="my-0" />
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Address</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input type="text" value="{{old('address', $user->address)}}" name="address" class="form-control px-2 py-1 border border-secondary @error('address') is-invalid @enderror" placeholder="Address">
                                                @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-end"><button type="submit" class="btn btn-sm btn-primary">Save</button></div>
                        </div>
                    </form>

                    <form method="post" action="{{route('security.settings')}}" class="validate">
                        @csrf
                        <div class="card p-4 mb-5">
                            <div class="col-12">
                                <div>
                                    <h1>Security</h1>
                                    <p class="text-muted">Change your password</p>
                                </div>
                                <div>
                                    <ul class="list-group ps-0">
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Current Password</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input type="password" name="current_password" value=""  class="form-control px-2 py-1 border border-secondary @error('current_password') is-invalid @enderror">
                                                @error('current_password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                        <hr class="my-0" />
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">New Password</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input type="password" name="password" value=""  class="form-control px-2 py-1 border border-secondary @error('password') is-invalid @enderror">
                                                @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </li>
                                        <hr class="my-0" />
                                        <li class="list-group-item row ps-0">
                                            <span class="col-4 m-auto">Confirm Password</span>
                                            <div class="col-8 form-floating d-inline-block">
                                                <input type="password" name="password_confirmation" value=""  class="form-control px-2 py-1 border border-secondary">
                                               </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-end"><button type="submit" class="btn btn-sm btn-primary">Save</button></div>
                        </div>
                    </form>


                </div>
            </div>
        </div></section>
@endsection
@section('js')

    <script src="{{asset('js/settings.js')}}"></script>
@endsection
