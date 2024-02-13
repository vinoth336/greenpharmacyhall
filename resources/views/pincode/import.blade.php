@extends('layouts.app', ['activePage' => 'Product Images', 'titlePage' => __('Create Product delivery Estimation')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('pincode.import') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Import Pincode Delivery Estimation List') }}</h4>
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
                                    <div class="col-sm-12">
                                        <div class="text-center">
                                            <label class="col-form-label">{{ __('Import') }}</label>
                                            <input name="pincode_list"  type="file" />
                                            @if ($errors->has('pincode_list'))
                                                <span id="product_list-error" class="error text-danger"
                                                    for="input-product_list">{{ $errors->first('pincode_list') }}</span>
                                            @endif
                                        </div>
                                        <div class="text-center" style="margin-top: 10px">
                                            <a href="{{ asset('admin/import_delivery_estimate_based_on_pincode.xlsx') }}" target="_blank">
                                                Sample File
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <a href="{{ route('product.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Import') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
