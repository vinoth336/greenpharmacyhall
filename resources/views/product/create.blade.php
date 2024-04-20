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
                                                name="services[]" id="input-service" multiple>
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
                                                placeholder="{{ __('Sub Category') }}">
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
                                                placeholder="{{ __('Brand Name') }}">
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
                                    <label class="col-sm-2 col-form-label">{{ __('Tags') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('tag') ? ' has-danger' : '' }}">
                                            <select
                                                class="form-control{{ $errors->has('tag') ? ' is-invalid' : '' }}"
                                                name="tags[]" id="input-tags"
                                                placeholder="{{ __('Tags') }}" multiple="multiple">
                                                @foreach($tags as $tag)
                                                    <option data-value="{{ $tag->name }}" value="{{ $tag->name }}" @if(in_array($tag->id, old('tags', []))) selected @endif >{{ $tag->name }}</option>
                                                @endforeach

                                            </select>
                                            @if ($errors->has('tags'))
                                                <span id="tags-error" class="error text-danger"
                                                    for="input-tags">{{ $errors->first('tags') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Qty Details') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('qty_details') ? ' has-danger' : '' }}">
                                        <textarea
                                            class="form-control{{ $errors->has('qty_details') ? ' is-invalid' : '' }}"
                                            name="qty_details" id="qty_details" placeholder="{{ __('Qty Details') }}">{{ old('qty_details') }}</textarea>
                                            @if ($errors->has('qty_details'))
                                                <span id="qty_details-error" class="error text-danger"
                                                      for="input-qty_details">{{ $errors->first('qty_details') }}</span>
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
                                                name="description" id="description" placeholder="{{ __('Description') }}">{{ old('description') }}</textarea>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Discount In %') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('discount_in_percentage') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('discount_in_percentage') ? ' is-invalid' : '' }}"
                                                name="discount_in_percentage" id="input-discount_in_percentage" type="text"
                                                placeholder="{{ __('Discount In Percenate') }}" value="{{ old('discount_in_percentage') }}"
                                            />
                                            @if ($errors->has('discount_in_percentage'))
                                                <span id="discount_amount-error" class="error text-danger"
                                                      for="input-discount_amount">{{ $errors->first('discount_in_percentage') }}</span>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Is Pharma Product') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('is_pharma_product') ? ' has-danger' : '' }}">
                                            <input style="width: 62px;"
                                                   class="form-control{{ $errors->has('is_pharma_product') ? ' is-invalid' : '' }}"
                                                   name="is_pharma_product" id="input-is_pharma_product" type="checkbox" value="1"
                                                   @if(old('is_pharma_product') == 1) checked @endif
                                                   aria-required="true" />
                                            @if ($errors->has('is_pharma_product'))
                                                <span id="is_pharma_product-error" class="error text-danger"
                                                      for="input-is_pharma_product">{{ $errors->first('is_pharma_product') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Is Scheduled Drug') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('is_scheduled_drug') ? ' has-danger' : '' }}">
                                            <input style="width: 62px;"
                                                   class="form-control{{ $errors->has('is_scheduled_drug') ? ' is-invalid' : '' }}"
                                                   name="is_scheduled_drug" id="input-is_scheduled_drug" type="checkbox" value="1"
                                                   @if(old('is_scheduled_drug') == 1) checked @endif
                                                   aria-required="true" />
                                            @if ($errors->has('is_scheduled_drug'))
                                                <span id="is_scheduled_drug-error" class="error text-danger"
                                                      for="input-is_scheduled_drug">{{ $errors->first('is_scheduled_drug') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Is For Sales') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('is_for_sales') ? ' has-danger' : '' }}">
                                            <input style="width: 62px;"
                                                   class="form-control{{ $errors->has('is_for_sales') ? ' is-invalid' : '' }}"
                                                   name="is_for_sales" id="input-status" type="checkbox" value="1"
                                                   @if(old('is_for_sales') == 1) checked @endif
                                                   aria-required="true" />
                                            @if ($errors->has('is_for_sales'))
                                                <span id="status-error" class="error text-danger"
                                                      for="input-is_for_sales">{{ $errors->first('is_for_sales') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Status') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                            <input style="width: 62px;"
                                                class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                                                name="status" id="input-status" type="checkbox" value="1"
                                                @if(old('status') == 1) checked @endif
                                                aria-required="true" />
                                            @if ($errors->has('status'))
                                                <span id="status-error" class="error text-danger"
                                                    for="input-status">{{ $errors->first('status') }}</span>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
            CKEDITOR.replace('description');
            $("#input-tags").select2({
                tags: true,
                tokenSeparators: [',']
            });


            $("#input-discount_in_percentage").on("keyup keydown", function() {
               var price = $("#input-price").val();
               var discountPer = $(this).val();
               if (discountPer) {
                   value =  (((discountPer/ 100) * price) + price).toFixed(2);
                   $("#input-discount_amount").val(value)
               } else {
                   $("#input-discount_amount").val('0.00');
               }
            });


    </script>
    @endpush
@endsection
