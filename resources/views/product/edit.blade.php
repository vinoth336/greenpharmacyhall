@extends('layouts.app', ['activePage' => 'Product Images', 'titlePage' => __('Edit Product Images')])

@section('content')

<link rel="stylesheet" href="{{ asset('web/css/draganddrop.css') }}" type="text/css" />
<script src="{{ asset('web/js/draganddrop.js') }}"></script>
<script>
$(document).ready(function() {
    $("#sortable")
        .sortable({
            handle: '.hand',
            group: true,
            update: function(event, ui) {
                updateSequence();
            }
        })
});

</script>
<style>
    ul.list-inline li {
        display: inline-block;
        margin: 5px;

    }
</style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('product.update', $product->slug) }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Edit Product Images') }}</h4>
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
                                        <div class="form-group{{ $errors->has('question') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                name="name" id="input-name" type="text"
                                                placeholder="{{ __('Image Name') }}" value="{{ old('name', $product->name) }}"
                                                required="true" aria-required="true" />
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
                                                placeholder="{{ __('Slug Name') }}" value="{{ old('slug_name', $product->slug) }}"
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
                                                placeholder="{{ __('Product Code') }}" value="{{ old('product_code', $product->product_code) }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('product_code'))
                                                <span id="product_code-error" class="error text-danger"
                                                    for="input-product_code">{{ $errors->first('product_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Service') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('service') ? ' has-danger' : '' }}">
                                            <select
                                                class="selectpicker form-control{{ $errors->has('service') ? ' is-invalid' : '' }}"
                                                name="services[]" id="input-service" type="text"
                                                placeholder="{{ __('Image Name') }}"
                                                required="true" aria-required="true" multiple>
                                                    <option value=''>Select Services</option>
                                                @php
                                                 $services_collection = $product->services()->pluck('services.id');
                                                @endphp

                                                @foreach($services as $service)

                                                    <option value="{{ $service->id }}" @if($services_collection->contains($service->id)) selected @endif >{{  $service->name }}</option>

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
                                                    <option value="{{ $subCategory->id }}" @if($subCategory->id == old('sub_category', $product->sub_category_id)) selected @endif >{{  $subCategory->name }}</option>
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
                                                 aria-required="true" >
                                                    <option value=''>Select Brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" @if($brand->id == old('brand', $product->brand_id)) selected @endif >{{  $brand->name }}</option>
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
                                                required>{{ old('description', $product->description) }}</textarea>
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
                                                placeholder="{{ __('Price') }}" value="{{ old('price', $product->price) }}"
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
                                                placeholder="{{ __('Discount Amount') }}" value="{{ old('discount_amount', $product->discount_amount) }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('discount_amount'))
                                                <span id="discount_amount-error" class="error text-danger"
                                                    for="input-discount_amount">{{ $errors->first('discount_amount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Status') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }} text-left">
                                            <input style="width: 62px;"
                                                class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                                name="status" id="input-status" type="checkbox" value="1"
                                                @if(old('status', $product->status) == 1) checked @endif
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

                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>

                            </div>
                        </div>
                    </form>
                </div>
                <hr>

                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-body ">
                    <h3>Images</h3>
                    <div class="row">
                    <ul class="list-inline" id="sortable">
                    @forelse ($product->productImages()->orderBy('sequence')->get() as $portfolioImage )
                        <li id="portfolio_image_{{ $portfolioImage->id }}">
                            <div class="dropdown" style="">
                                <a class=" dropdown-toggle text-" type="button" data-toggle="dropdown">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu">
                                  <li class="dropdown-header"><div class="text-danger" onclick="deletePortfolioImage('{{ $portfolioImage->id }}')"> Delete</div></li>
                                </ul>
                            </div>
                            <input type="hidden" name="sequence[]" value="{{ $portfolioImage->id }}" />
                            <img class="hand" style="width: 150px" src="{{ asset('web/images/product_images/thumbnails/' . $portfolioImage->image) }}"
                            alt="Justice">
                        </li>
                    @empty
                        <li >
                            <h5 class="text-center">NO IMAGES</h5>
                        </li>
                    @endforelse
                    </ul>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>

        CKEDITOR.replace('description');

        function updateSequence()
        {
            $.ajax({
                "url" : "/admin/product_images/update_sequence",
                "type" : "put",
                "dataType": "json",
                "data" : $("#sortable").find('[name="sequence[]"]').serialize(),
                "success" : function(data) {

                }
            });

        }


        function deletePortfolioImage(id)
        {

            $.ajax({
                "url" : "/admin/product_images/" + id,
                "type" : "delete",
                "dataType": "json",
                "success" : function(data) {
                    $("#portfolio_image_"+id).remove();
                }
            });

        }
    </script>
    @endpush

@endsection
