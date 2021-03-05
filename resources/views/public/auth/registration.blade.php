@extends('site.app')

@section('content')

<section id="content">
<div class="content-wrap">
<div class="container clearfix">
    <div class="row gutter-40 col-mb-80">
        <div class="postcontent col-lg-9">
            <div class="clear"></div>
            <div id="faqs" class="faqs">
                <h3>User Registration</h3>
                <form method="POST" action="{{ route('public.registration') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="inputAddress2">Name</label>
                            <input type="text" class="form-control" id="user_" placeholder="Name" name="user_name" value="{{ old('user_name') }}">
                            <span id="first_nameMsg" class="error">
                                @error('user_')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress2">Sex</label>
                            <select name="user_sex" class="form-control">
                                <option value="male" @if(old('user_sex') == 'male') selected @endif>Male</option>
                                <option value="female" @if(old('user_sex') == 'female') selected @endif>FeMale</option>
                            </select>
                            <span id="first_nameMsg" class="error">
                                @error('user_sex')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress2">Phone No</label>
                            <input type="text" class="form-control" id="user_phone" placeholder="----------" min="10" max="10" name="user_phone_no" value="{{ old('user_phone_no') }}">
                            <span id="first_nameMsg" class="error">
                                @error('user_phone_no')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Password</label>
                            <input type="password" class="form-control" id="user_password" placeholder="Password" name="user_password" min="6">
                            <span id="first_nameMsg" class="error">
                                @error('user_password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email Id</label>
                            <input type="email" class="form-control" id="user_email" placeholder="Email Id" name="user_email" value="{{ old('user_email') }}">
                            <span id="first_nameMsg" class="error">
                                @error('user_email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <textarea class="form-control" id="user_address" name="user_address">{{ old('user_address') }}</textarea>
                        <span id="first_nameMsg" class="error">
                            @error('user_address')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">City</label>
                            <input type="text" class="form-control" id="user_city" name="user_city" value="Karur">
                            <span id="first_nameMsg" class="error">
                                @error('user_city')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">State</label>
                            <input type="text" class="form-control" id="user_state" name="user_state" value="Tamil Nadu">
                            <span id="first_nameMsg" class="error">
                                @error('user_state')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Zip</label>
                            <input type="text" class="form-control" id="user_zip" name="user_zipcode" min="6" max="6" value="{{ old('user_zipcode') }}">
                            <span id="first_nameMsg" class="error">
                                @error('user_zipcode')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</section>


@endsection
