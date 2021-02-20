@extends('layouts.app', ['activePage' => 'services', 'titlePage' => __('Create services')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('services.store') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Create services') }}</h4>

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
                                    <label class="col-sm-2 col-form-label">{{ __('Category Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}"
                                                name="name" id="input-contact_person" type="text"
                                                placeholder="{{ __('Service Name') }}" value="{{ old('name') }}"
                                                required="true" aria-required="true"  onfocusOut='getSlugName($(this).val())' />
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('name') }}</span>
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
                                                placeholder="{{ __('Slug Name') }}" value="{{ old('slug_name') }}"
                                                required="true" aria-required="true" readonly />
                                            @if ($errors->has('slug_name'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-slug_name">{{ $errors->first('slug_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Category Type') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('icon') ? ' has-danger' : '' }}">
                                            <select name="category_type" class="selectpicker">
                                                @foreach($category_types as $category_type)
                                                    <option value="{{ $category_type->id }}"
                                                        @if(old('category_type') == $category_type->id)
                                                            selected
                                                        @endif
                                                    > {{ $category_type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category_type'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-category_type">{{ $errors->first('category_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                            <textarea
                                                class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                                name="description" id="description" placeholder="{{ __('Description') }}"
                                                required>{{ old('description') }}</textarea>
                                            @if ($errors->has('description'))
                                                <span id="phone_no-error" class="error text-danger"
                                                    for="input-phone_no">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Banner') }}</label>
                                    <div class="col-sm-7">

                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                              <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                              <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="banner" accept="image/x-png,image/jpg,image/jpeg" >
                                              </span>
                                              <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                          </div>
                                          @if ($errors->has('banner'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('banner') }}</span>
                                          @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <a href="{{ route('services.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
