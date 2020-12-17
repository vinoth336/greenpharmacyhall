@extends('layouts.app', ['activePage' => 'typography', 'titlePage' => __('Typography')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('profile.update') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Site Information') }}</h4>
                
              </div>
              <div class="card-body ">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Contact Person') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('contact_person') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}" name="contact_person" id="input-contact_person" type="text" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required="true" aria-required="true"/>
                      @if ($errors->has('contact_person'))
                        <span id="name-error" class="error text-danger" for="input-contact_person">{{ $errors->first('contact_person') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Phone No') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('phone_no') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('phone_no') ? ' is-invalid' : '' }}" name="phone_no" id="input-email" type="email" placeholder="{{ __('Phone No') }}" value="{{ old('phone_no', auth()->user()->email) }}" required />
                      @if ($errors->has('phone_no'))
                        <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('phone_no') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Facebook Page') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('facebook_page') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('facebook_page') ? ' is-invalid' : '' }}" name="facebook_page" id="input-facebook_page" type="facebook_page" placeholder="{{ __('Facebook Page Url') }}" value="{{ old('facebook_page', auth()->user()->email) }}" required />
                        @if ($errors->has('phone_no'))
                          <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('phone_no') }}</span>
                        @endif
                      </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Instagram Page') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('facebook_page') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('facebook_page') ? ' is-invalid' : '' }}" name="facebook_page" id="input-facebook_page" type="facebook_page" placeholder="{{ __('Facebook Page Url') }}" value="{{ old('facebook_page', auth()->user()->email) }}" required />
                        @if ($errors->has('phone_no'))
                          <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('phone_no') }}</span>
                        @endif
                      </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Working Hours') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('facebook_page') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('facebook_page') ? ' is-invalid' : '' }}" name="facebook_page" id="input-facebook_page" type="facebook_page" placeholder="{{ __('Facebook Page Url') }}" value="{{ old('facebook_page', auth()->user()->email) }}" required />
                        @if ($errors->has('phone_no'))
                          <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('phone_no') }}</span>
                        @endif
                      </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('facebook_page') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('facebook_page') ? ' is-invalid' : '' }}" name="facebook_page" id="input-facebook_page" type="facebook_page" placeholder="{{ __('Facebook Page Url') }}" value="{{ old('facebook_page', auth()->user()->email) }}" required />
                        @if ($errors->has('phone_no'))
                          <span id="phone_no-error" class="error text-danger" for="input-phone_no">{{ $errors->first('phone_no') }}</span>
                        @endif
                      </div>
                    </div>
                </div>

              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
@endsection