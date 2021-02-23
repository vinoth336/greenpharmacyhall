@extends('layouts.app', ['activePage' => 'banner', 'titlePage' => __('Edit banner')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('banner.update', $banner->id) }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Edit Banner') }}</h4>

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
                                    <label class="col-sm-2 col-form-label">{{ __('Banner Size') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('banner_size') ? ' has-danger' : '' }}">
                                            @php
                                            $size = [3 => '436x224', 6 => '730x192', 8 => '380x382'];
                                            @endphp
                                            <select name="banner_size">
                                                    @foreach(BANNER_SIZE as $value => $label)
                                                        <option value="{{ $value }}" @if($value == old('banner_size', $banner->banner_size)) selected @endif>Size {{ $label }} </option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('banner_size'))
                                                <span id="banner_size-error" class="error text-danger"
                                                    for="input-banner_size">{{ $errors->first('banner_size') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Slider') }}</label>
                                    <div class="col-sm-7">

                                        <div class="fileinput @if(!$banner->banner) fileinput-new @else fileinput-exists @endif text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                              <img src="{{ asset('material') . "/img/image_placeholder.jpg" }}" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail">
                                                    <img src="{{ asset('web/images/banners/' . $banner->banner ) }}" />
                                            </div>
                                            <div>
                                              <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="hidden" name="remove_image" value="" />
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
                                <a href="{{ route('banner.index') }}" class="btn btn-info">{{ __('Cancel') }}</a>

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
          $("[name='remove_image']").val(1);
        });
        </script>
@endsection
