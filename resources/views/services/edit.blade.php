@extends('layouts.app', ['activePage' => 'services', 'titlePage' => __('Edit services')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('services.update', $service->id) }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Edit services') }}</h4>

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
                                    <label class="col-sm-2 col-form-label">{{ __('Service Name') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('question') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('contact_person') ? ' is-invalid' : '' }}"
                                                name="name" id="input-contact_person" type="text"
                                                placeholder="{{ __('Service Name') }}" value="{{ old('name', $service->name) }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Service Icon') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('icon') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('icon') ? ' is-invalid' : '' }}"
                                                name="icon" id="input-contact_person" type="text"
                                                placeholder="{{ __('Service Icon') }}" value="{{ old('icon', $service->icon) }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('icon'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-contact_person">{{ $errors->first('icon') }}</span>
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
                                                required>{{ old('description', $service->description) }}</textarea>
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

                                        <div class="fileinput @if(!$service->banner) fileinput-new @else fileinput-exists @endif text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                              <img src="{{ asset('material') . "/img/image_placeholder.jpg" }}" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail">
                                                    <img src="{{ asset('web/images/portfolio_images/thumbnails/' . $service->banner ) }}" />
                                            </div>
                                            <div>
                                              <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="hidden" name="remove_banner" value="" />
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

                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("[data-dismiss='fileinput']").on('click', function() {
          $("[name='remove_banner']").val(1);
        });
        </script>
@endsection