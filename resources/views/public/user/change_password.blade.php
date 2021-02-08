@extends('site.app')

@section('content')

    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="col-md-9">
                        <div class="row clearfix">
                            <div class="col-lg-12">
                                @error('error')
                                    <div class="style-msg errormsg">
                                        <div class="sb-msg"><i class="icon-thumbs-up"></i>
                                            {!! implode(" <br> ", $errors->get('error') ) !!}
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    </div>
                                @enderror
                                @if(session()->has('status'))
                                    <div class="style-msg successmsg">
                                        <div class="sb-msg"><i class="icon-thumbs-up"></i>
                                            {{ session('status') }}
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    </div>
                                @endif

                                <h3>Change Password</h3>
                                <hr>
                                <div class="clear"></div>
                                <form method="POST" id="profile_update" action="{{ route('public.change_password') }}">
                                    @csrf
                                    @method('post')
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label for="inputAddress2">Current Password</label>
                                            <input type="password" class="form-control  form-input" id="current_password"
                                                placeholder="Name" name="current_password" value="{{ old('current_password') }}">
                                            <span id="current_password" class="text-danger">
                                                @error('current_password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label for="inputAddress2">New Password</label>
                                            <input type="password" class="form-control  form-input" id="current_password"
                                                placeholder="Name" name="new_password" value="">
                                            <span id="new_password" class="text-danger">
                                                @error('new_password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label for="inputAddress2">Confirm Password</label>
                                            <input type="password" class="form-control  form-input" id="current_password"
                                                placeholder="Name" name="confirm_password" value="">
                                            <span id="confirm_password" class="text-danger">
                                                @error('confirm_password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('public.dashboard') }}" class="btn btn-danger" >Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 line d-block d-md-none"></div>
                    <div class="col-md-3">
                        @include('public.user.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
