@extends('layouts.app', ['activePage' => 'slider', 'titlePage' => __('Slider')])

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
                        <h4 class="card-title float-left">{{ __('Sliders') }}</h4>
                        <a href="{{ route('slider.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                    </div>
                    <div class="card-body ">

                        <ul class="accordion" id="sortable">
                            @foreach ($sliders as $slider )
                            <li class="card">

                                <div class="card-header" id="heading{{ $slider->id }}">
                                    <div class="pull-left">
                                    <a class="hand"><i class="material-icons">reorder</i></a>
                                        <img src="{{ asset('web/images/slider/' . $slider->slider ) }}" style="width:150px;display:inline-block" class="inline-block" />
                                        <p style="display:inline-block;text-align:justify">{{ $slider->description }}</p>
                                        <input type="hidden" name="sequence[]" value="{{ $slider->id }}" />
                                    </div>
                                    <div class="pull-right">
                                        <form onsubmit="Javascript: return confirm('Are You Sure, Want To Remove This ?');"  method="POST" action="{{ route('slider.destroy', $slider->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-sm btn-success" data-original-title title><i class="material-icons">edit</i></a>
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
            "url" : "/admin/slider/update_sequence",
            "type" : "put",
            "dataType": "json",
            "data" : $("#sortable").find('[name="sequence[]"]').serialize(),
            "success" : function(data) {
            }
        });

    }

</script>

@endsection
