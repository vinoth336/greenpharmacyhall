@extends('layouts.app', ['activePage' => 'notification_manager', 'titlePage' => __('Notifiaction Manager')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('notification_manager.store') }}" autocomplete="off"
                        class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Notification Manager') }}</h4>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Order Create') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('order_create') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('min_home_delivery_order_amount') ? ' is-invalid' : '' }}"
                                                name="order_create" id="input-contact_person" type="email"
                                                placeholder="{{ __('Email Notification For Order Create') }}"
                                                value="{{ old('order_create', $NotificationManager->order_create) }}" required="true"
                                                aria-required="true" />
                                            @if ($errors->has('order_create'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('order_create') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Order Cancel') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('order_cancel') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('order_cancel') ? ' is-invalid' : '' }}"
                                                name="order_cancel" id="input-order_cancel" type="email"
                                                placeholder="{{ __('Email Notification For Order Cancel') }}"
                                                value="{{ old('order_cancel', $NotificationManager->order_cancel) }}"
                                                 />
                                            @if ($errors->has('facebook_id'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-order_cancel">{{ $errors->first('order_cancel') }}</span>
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
