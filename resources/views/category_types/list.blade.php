@extends('layouts.app', ['activePage' => 'category_types', 'titlePage' => __('Category Types')])

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
                        <h4 class="card-title float-left">{{ __('Category Types') }}</h4>
                        <a href="{{ route('category_types.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                    </div>
                    <div class="card-body ">

                        <ul class="accordion" id="sortable">
                            @foreach ($category_types as $category_type )
                            <li class="card">
                                <div class="card-header" id="heading{{ $category_type->id }}">
                                    <div class="pull-left">
                                        <h5 class="mb-0" data-toggle="collapse"
                                                data-target="#collapse{{ $category_type->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $category_type->id }}">
                                                <a class="hand"><i class="material-icons">reorder</i></a>
                                                {{ ucwords($category_type->name) }}
                                        </h5>
                                        <input type="hidden" name="sequence[]" value="{{ $category_type->id }}" />
                                    </div>
                                    <div class="pull-right">
                                        <form onsubmit="Javascript: return confirm('Are You Sure, Want To Remove This ?');"  method="POST" action="{{ route('category_types.destroy', $category_type->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('category_types.edit', $category_type->id) }}" class="btn btn-sm btn-success" data-original-title title><i class="material-icons">edit</i></a>
                                           <button type="submit" class="btn  btn-sm btn-danger"><i class="material-icons" data-original-title title>close</i></button>
                                        </form>
                                    </div>
                                </div>

                                <div id="collapse{{ $category_type->id }}" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        {{ $category_type->answer }}
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
            "url" : "/admin/category_types/update_sequence",
            "type" : "put",
            "dataType": "json",
            "data" : $("#sortable").find('[name="sequence[]"]').serialize(),
            "success" : function(data) {
                    console.log(data);
                    alert("Update Successfully");
            }
        });

    }

</script>

@endsection
