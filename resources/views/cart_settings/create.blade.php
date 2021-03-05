@extends('layouts.app', ['activePage' => 'cart_settings', 'titlePage' => __('Cart Settings')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('cart_settings.store') }}" autocomplete="off"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Cart Settings') }}</h4>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Free Delivery - Min Order Amount') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('site_name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('min_home_delivery_order_amount') ? ' is-invalid' : '' }}"
                                                name="min_home_delivery_order_amount" id="input-contact_person" type="number"
                                                placeholder="{{ __('Free Delivery - Min Order Amount') }}"
                                                value="{{ old('min_home_delivery_order_amount', $CartSettings->min_home_delivery_order_amount) }}" required="true"
                                                aria-required="true" />
                                            @if ($errors->has('min_home_delivery_order_amount'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('min_home_delivery_order_amount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Shop Pickup - Min Order Amount') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('min_shop_pickup_order_amount') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('min_shop_pickup_order_amount') ? ' is-invalid' : '' }}"
                                                name="min_shop_pickup_order_amount" id="input-min_shop_pickup_order_amount" type="text"
                                                placeholder="{{ __('Shop Pickup - Min Order Amount') }}"
                                                value="{{ old('min_shop_pickup_order_amount', $CartSettings->min_shop_pickup_order_amount) }}"
                                                 />
                                            @if ($errors->has('facebook_id'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-min_shop_pickup_order_amount">{{ $errors->first('min_shop_pickup_order_amount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary m-auto">{{ __('Save') }}</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
