@extends('layouts.app', ['activePage' => 'banner', 'titlePage' => __('banner')])

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
<div class="content">
<div class="container-fluid">
    <div class="row">

        @if (session('status'))

            <div class="col-md-12">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                    </button>
                    <span>{{ session('status') }}</span>
                </div>
            </div>

    @endif

        <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title float-left">{{ __('Banner') }}</h4>
                        <a href="{{ route('banner.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                    </div>
                    <div class="card-body ">

                        <ul class="accordion" id="sortable">
                            @foreach ($banners as $banner )
                            <li class="card">

                                <div class="card-header" id="heading{{ $banner->id }}">
                                    <div class="pull-left">
                                    <a class="hand"><i class="material-icons">reorder</i></a>
                                        <img src="{{ asset('web/images/banners/' . $banner->banner ) }}" style="width:150px;display:inline-block" class="inline-block" />
                                        <p style="display:inline-block;text-align:justify">{{ $banner->description }}</p>
                                        <input type="hidden" name="sequence[]" value="{{ $banner->id }}" />
                                    </div>
                                    <div class="pull-right">
                                        <form onsubmit="Javascript: return confirm('Are You Sure, Want To Remove This ?');"  method="POST" action="{{ route('banner.destroy', $banner->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-sm btn-success" data-original-title title><i class="material-icons">edit</i></a>
                                           <button type="submit" class="btn  btn-sm btn-danger"><i class="material-icons" data-original-title title>close</i></button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>
<script>

    function updateSequence()
    {
        $.ajax({
            "url" : "/admin/banners/update_sequence",
            "type" : "put",
            "dataType": "json",
            "data" : $("#sortable").find('[name="sequence[]"]').serialize(),
            "success" : function(data) {
            }
        });

    }

</script>

@endsection
