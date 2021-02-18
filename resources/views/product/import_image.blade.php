@extends('layouts.app', ['activePage' => 'Product Images', 'titlePage' => __('Create Product')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                    @endif
                    <form method="post" action="{{ route('product.import_image') }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Import Product Image') }}</h4>
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
                                            <label class="col-form-label">{{ __('Import Image') }}</label>
                                            <input name="product_images[]"  type="file" multiple />
                                            @if ($errors->has('product_list'))
                                                <span id="product_list-error" class="error text-danger"
                                                    for="input-product_list">{{ $errors->first('product_list') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="text-center">
                                            <label class="col-form-label">{{ __('Action') }}</label>
                                            <input type="radio" name="action" value="override_update" checked>&nbsp;Replace and Add New Content <br>
                                            <input type="radio" name="action" value="update">&nbsp;Add New Content Only <br>
                                            @if ($errors->has('action'))
                                                <span id="action-error" class="error text-danger"
                                                    for="input-action">{{ $errors->first('action') }}</span>
                                            @endif
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
