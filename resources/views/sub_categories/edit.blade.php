@extends('layouts.app', ['activePage' => 'sub_categories', 'titlePage' => __('Edit Sub Category')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('sub_categories.update', $subCategory->id) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit Category Types') }}</h4>

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
                  <label class="col-sm-2 col-form-label">{{ __('Sub Category Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-contact_person" type="text" onfocusOut='getSlugName($(this).val())'
                      placeholder="{{ __('Sub Category Nmae') }}" value="{{ old('name', $subCategory->name) }}" required="true" aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Slug Name') }}</label>
                    <div class="col-sm-7">
                        <div class="form-group{{ $errors->has('slug_name') ? ' has-danger' : '' }}">
                            <input
                                class="form-control{{ $errors->has('slug_name') ? ' is-invalid' : '' }}"
                                name="slug_name" id="input-slug_name" type="text"
                                placeholder="{{ __('Slug Name') }}" value="{{ old('slug_name', $subCategory->slug_name) }}"
                                required="true" aria-required="true" readonly />
                            @if ($errors->has('slug_name'))
                                <span id="name-error" class="error text-danger"
                                    for="input-slug_name">{{ $errors->first('slug_name') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <a href="{{ route('sub_categories.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>

                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
@endsection
