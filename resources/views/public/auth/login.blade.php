@extends('site.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('Material Dashboard')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-8 col-md-12 m-auto">
                <form class="mt-5" method="post" action="{{ route('public.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone No</label>
                        <input type="number" class="form-control" name="phone_no" placeholder="Enter Phone No" min="10">
                        <span id="first_nameMsg" class="error">
                            @error('phone_no')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">One Time Password (OTP)</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        @error('password')
                                {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1" checked>
						<label class="form-check-label" for="exampleCheck1">Remember Me</label>
                    </div>
                    <div class="m-auto text-center">
                    <button type="submit" class="btn btn-warning text-white" style="background-color: #fb641b; padding-left: 10%; padding-right:10%">
                        Login
                    </button>
                    </div>
                </form>

                <div class="mt-5 text-center mb-5">
                    <a href="{{ route('public.registration') }}">
                        New User ? Create an account
                    </a>
                </div>
      </div>
  </div>
</div>
@endsection
