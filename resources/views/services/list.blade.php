@extends('layouts.app', ['activePage' => 'typography', 'titlePage' => __('Typography')])

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
                        <h4 class="card-title float-left">{{ __('services') }}</h4>
                        <a href="{{ route('services.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                    </div>
                    <div class="card-body ">

                        <ul class="accordion" id="sortable">
                            @foreach ($services as $service )
                            <li class="card">
                                <div class="card-header" id="heading{{ $service->id }}">
                                    <div class="pull-left">
                                        <h5 class="mb-0" data-toggle="collapse"
                                                data-target="#collapse{{ $service->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $service->id }}">
                                                <a class="hand"><i class="material-icons">reorder</i></a>
                                                @if(file_exists(public_path('web/images/portfolio_images/thumbnails/' . $service->banner)))
                                                <img src="{{ asset('web/images/portfolio_images/thumbnails/' . $service->banner ) }}" style="width:70px;display:inline-block" class="inline-block" />
                                                @else
                                                <img src="{{ asset('site_images/no-image.png') }}" style="width:70px;display:inline-block" class="inline-block" />
                                                @endif

                                                {{ ucwords($service->name) }}
                                        </h5>
                                        <input type="hidden" name="sequence[]" value="{{ $service->id }}" />
                                    </div>
                                    <div class="pull-right">
                                        <form onsubmit="Javascript: return confirm('Are You Sure, Want To Remove This ?');"  method="POST" action="{{ route('services.destroy', $service->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-success" data-original-title title><i class="material-icons">edit</i></a>
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
            "url" : "/admin/services/update_sequence",
            "type" : "put",
            "dataType": "json",
            "data" : $("#sortable").find('[name="sequence[]"]').serialize(),
            "success" : function(data) {

            }
        });

    }

</script>

@endsection
