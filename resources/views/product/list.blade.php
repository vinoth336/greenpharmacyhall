@extends('layouts.app', ['activePage' => 'typography', 'titlePage' => __('Product')])

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
                        <h4 class="card-title float-left">{{ __('product') }}</h4>
                        <a href="{{ route('product.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                              <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Import
                              </button>
                              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="{{ route('product.import') }}?type=product">Import Product</a>
                                <a class="dropdown-item" href="{{ route('product.import') }}?type=product_image">Import Image</a>
                              </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body ">
                        <ul class="accordion" id="sortable">
                            @foreach ($products as $product )
                            @if(!empty($product))
                                <li class="card">
                                    <div class="card-header" id="heading{{ $product->id }}">
                                        <div class="pull-left">
                                            <h5 class="mb-0" data-toggle="collapse"
                                                    data-target="#collapse{{ $product->id }}" aria-expanded="true"
                                                    aria-controls="collapse{{ $product->id }}">
                                                    <a class="hand"><i class="material-icons">reorder</i></a>
                                                    @if($product->brand)
                                                        <b>{{ ucwords($product->brand->name) }}</b> -
                                                    @endif
                                                    {{ ucwords($product->name) }}
                                                    <br>
                                                    <i class="fa fa-tag" aria-hidden="true"></i>&nbsp;
                                                    <small>{{ implode(',' ,$product->services()->pluck('name')->toArray()) }}</small>
                                            </h5>
                                            <input type="hidden" name="sequence[]" value="{{ $product->id }}" />
                                        </div>
                                        <div class="pull-right">
                                            <form onsubmit="Javascript: return confirm('Are You Sure, Want To Remove This ?');"  method="POST" action="{{ route('product.destroy', $product->slug) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('product.edit', $product->slug) }}" class="btn btn-sm btn-success" data-original-title title><i class="material-icons">edit</i></a>
                                            <button type="submit" class="btn  btn-sm btn-danger"><i class="material-icons" data-original-title title>close</i></button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endif
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
            "url" : "/admin/product/update_sequence",
            "type" : "put",
            "dataType": "json",
            "data" : $("#sortable").find('[name="sequence[]"]').serialize(),
            "success" : function(data) {

            }
        });

    }

</script>

@endsection
