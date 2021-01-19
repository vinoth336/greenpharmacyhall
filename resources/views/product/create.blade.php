@extends('layouts.app', ['activePage' => 'Product Images', 'titlePage' => __('Create Product')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('product.store') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Create Product Images') }}</h4>

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

                                    <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                name="name" id="input-name" type="text"
                                                placeholder="{{ __('Product Name') }}" value="{{ old('name') }}"
                                                required="true" aria-required="true" onfocusOut='getSlugName($(this).val())' />
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-name">{{ $errors->first('name') }}</span>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Product Code') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('product_code') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('product_code') ? ' is-invalid' : '' }}"
                                                name="product_code" id="input-product_code" type="text"
                                                placeholder="{{ __('Product Code') }}" value="{{ old('product_code') }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('product_code'))
                                                <span id="product_code-error" class="error text-danger"
                                                    for="input-product_code">{{ $errors->first('product_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Category') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('service') ? ' has-danger' : '' }}">
                                            <select
                                                class="selectpicker form-control{{ $errors->has('service') ? ' is-invalid' : '' }}"
                                                name="services[]" id="input-service" type="text"
                                                placeholder="{{ __('Image Name') }}"
                                                required="true" aria-required="true" >
                                                    <option value=''>Select Category</option>
                                                @foreach($services as $service)

                                                    <option value="{{ $service->id }}" @if($service->id == old('service')) selected @endif >{{  $service->name }}</option>

                                                @endforeach

                                            </select>
                                            @if ($errors->has('service'))
                                                <span id="service-error" class="error text-danger"
                                                    for="input-service">{{ $errors->first('service') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Sub Category') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('sub_category') ? ' has-danger' : '' }}">
                                            <select
                                                class="selectpicker form-control{{ $errors->has('sub_category') ? ' is-invalid' : '' }}"
                                                name="sub_category" id="input-service" type="text"
                                                placeholder="{{ __('Sub Category') }}"
                                                required="true" aria-required="true" >
                                                    <option value=''>Select Sub Category</option>
                                                @foreach($subCategories as $subCategory)
                                                    <option value="{{ $subCategory->id }}" @if($subCategory->id == old('sub_category')) selected @endif >{{  $subCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('service'))
                                                <span id="service-error" class="error text-danger"
                                                    for="input-service">{{ $errors->first('sub_category') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Brand') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('brand') ? ' has-danger' : '' }}">
                                            <select
                                                class="selectpicker form-control{{ $errors->has('brand') ? ' is-invalid' : '' }}"
                                                name="brand" id="input-brand" type="text"
                                                placeholder="{{ __('Brand Name') }}"
                                                required="true" aria-required="true" >
                                                    <option value=''>Select Brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" @if($brand->id == old('brand')) selected @endif >{{  $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('brand'))
                                                <span id="brand-error" class="error text-danger"
                                                    for="input-brand">{{ $errors->first('brand') }}</span>
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

                                    <label class="col-sm-2 col-form-label">{{ __('Price') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                                name="price" id="input-price" type="text"
                                                placeholder="{{ __('Price') }}" value="{{ old('price') }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('price'))
                                                <span id="price-error" class="error text-danger"
                                                    for="input-price">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Discount Amount') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('discount_amount') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('discount_amount') ? ' is-invalid' : '' }}"
                                                name="discount_amount" id="input-discount_amount" type="text"
                                                placeholder="{{ __('Discount Amount') }}" value="{{ old('discount_amount') }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('discount_amount'))
                                                <span id="discount_amount-error" class="error text-danger"
                                                    for="input-discount_amount">{{ $errors->first('discount_amount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h2 class="col-sm-2 col-form-label ">
                                        Product Images
                                    </h2>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-7">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <input type="file" name="product_images[]" accept="image/x-png,image/jpg,image/jpeg" multiple>
                                          </div>
                                          @if ($errors->has('product_images'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-name">{{ $errors->first('product_images') }}</span>
                                          @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <a href="{{ route('product.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script>
            CKEDITOR.replace('description');
    </script>
    @endpush
@endsection
