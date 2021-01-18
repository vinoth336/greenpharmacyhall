<div>
    <h6>
        Existing customer?&nbsp;<a href="Javascript:void(0);" onclick="Cart.showLoginForm()">Click here to login</a>
    </h6>
    <hr>
    <h6>
        <u>New User Registration</u>
    </h6>
    <form method="POST" action="{{ route('public.registration') }}">
        @csrf
        <input type="hidden" name="redirectTo" value="checkout" />
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="inputAddress2">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ old('name') }}">
                <span id="first_nameMsg" class="error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group col-md-3">
                <label for="inputAddress2">Sex</label>
                <select name="sex" class="form-control">
                    <option value="male" @if(old('sex') == 'male') selected @endif>Male</option>
                    <option value="female" @if(old('sex') == 'female') selected @endif>FeMale</option>
                </select>
                <span id="first_nameMsg" class="error">
                    @error('sex')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputAddress2">Phone No</label>
                <input type="text" class="form-control" id="phone" placeholder="----------" min="10" max="10" name="phone_no" value="{{ old('phone_no') }}">
                <span id="first_nameMsg" class="error">
                    @error('phone_no')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress">Address</label>
            <textarea class="form-control" id="address" name="address">{{ old('address') }}</textarea>
            <span id="first_nameMsg" class="error">
                @error('address')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">City</label>
                <input type="text" class="form-control" id="city" name="city" value="Karur">
                <span id="first_nameMsg" class="error">
                    @error('city')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">State</label>
                <input type="text" class="form-control" id="state" name="state" value="Tamil Nadu">
                <span id="first_nameMsg" class="error">
                    @error('state')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Zip</label>
                <input type="text" class="form-control" id="zip" name="zipcode" min="6" max="6" value="{{ old('zipcode') }}">
                <span id="first_nameMsg" class="error">
                    @error('zipcode')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') }}">
                <span id="first_nameMsg" class="error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password" min="6">
                <span id="first_nameMsg" class="error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary float-right">Sign in</button>
    </form>
</div>
