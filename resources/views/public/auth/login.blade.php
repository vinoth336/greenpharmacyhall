@extends('site.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('Material Dashboard')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-8 col-md-12 m-auto">
                <form class="mt-5" method="post" action="{{ route('public.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email">
                        <span id="first_nameMsg" class="error">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        @error('password')
                                {{ $message }}
                        @enderror
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
