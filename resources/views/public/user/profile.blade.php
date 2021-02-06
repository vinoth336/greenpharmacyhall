<h3>User Profile</h3>
    <div class="">
        <button id="profile_edit_button" type="button" class="btn btn-info float-right" onclick="enableForm()">
            <i class="icon-pencil"></i>
            Edit
        </button>
    </div>
    <div class="clear"></div>
                <form method="POST" id="profile_update" action="{{ route('public.update_profile') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="inputAddress2">Name</label>
                            <input disabled type="text" class="form-control  form-input" id="name" placeholder="Name" name="name" value="{{ old('name', $user->name) }}">
                            <span id="first_nameMsg" class="error">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress2">Sex</label>
                            <select  disabled name="sex" class="form-control  form-input">
                                <option value="male" @if(old('sex', $user->sex) == 'male') selected @endif>Male</option>
                                <option value="female" @if(old('sex', $user->sex) == 'female') selected @endif>FeMale</option>
                            </select>
                            <span id="first_nameMsg" class="error">
                                @error('sex')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAddress2">Phone No</label>
                            <input  disabled type="text" class="form-control" id="phone" placeholder="----------" min="10" max="10" disabled name="phone_no" value="{{ old('phone_no', $user->phone_no) }}">
                            <span id="first_nameMsg" class="error">
                                @error('phone_no')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <textarea  disabled class="form-control  form-input" id="address" name="address">{{ old('address', $user->address) }}</textarea>
                        <span id="first_nameMsg" class="error">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">City</label>
                            <input  disabled type="text" class="form-control  form-input" id="city" name="city" value="Karur">
                            <span id="first_nameMsg" class="error">
                                @error('city')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">State</label>
                            <input  disabled type="text" class="form-control  form-input" id="state" name="state" value="Tamil Nadu">
                            <span id="first_nameMsg" class="error">
                                @error('state')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Zip</label>
                            <input  disabled type="text" class="form-control  form-input" id="zip" name="zipcode" min="6" max="6" value="{{ old('zipcode', $user->zipcode) }}">
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
                            <input  disabled type="email" class="form-control  form-input" id="email" placeholder="Email" name="email" value="{{ old('email', $user->email) }}">
                            <span id="first_nameMsg" class="error">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <button id="show_form_submit_button" type="submit" class="btn btn-primary d-none">Update</button>
                    <button id="disable_form_values" type="button" class="btn btn-danger d-none" onclick="disableForm()">Cancel</button>
                </form>

@push('js')
    <script>
            function enableForm()
            {
                $("#profile_update").find(".form-input").removeAttr('disabled');
                $("#show_form_submit_button").removeClass('d-none');
                $("#disable_form_values").removeClass('d-none');
                $("#profile_edit_button").addClass('d-none');
            }

            function disableForm()
            {
                $("#profile_update").find(".form-input").attr('disabled', true);
                $("#show_form_submit_button").addClass('d-none');
                $("#disable_form_values").addClass('d-none');
                $("#profile_edit_button").removeClass('d-none');
            }
    </script>
@endpush
