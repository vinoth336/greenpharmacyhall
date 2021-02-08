@extends('layouts.app', ['activePage' => 'typography', 'titlePage' => __('Product')])

@section('content')
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
                        <h4 class="card-title float-left">{{ __('Product') }}</h4>
                        <a href="{{ route('product.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>
                        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown" style="margin-right: 10px;margin-top: 5px !important;">
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
                        <div class="table-responsive">

                            <table id="table_product_list" class="table table-striped table-no-bordered table-hover dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>S NO</th>
                                        <th>Name</th>
                                        <th>Services</th>
                                        <th>Sub Category</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Discount Price</th>
                                        <th>Image Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark text-bold">
                                    @php
                                        $sno = 1;
                                    @endphp
                                    @foreach ($products as $product )
                                        @if(!empty($product))
                                            <tr id="row_{{ $product->slug }}">
                                                <td class="product_sequence_no">{{ $sno++ }}
                                                <td>
                                                    <a href="{{ route('view_product', $product->slug) }}" target="_blank">
                                                        {{ ucwords($product->name) }}
                                                    </a>
                                                    <br>
                                                    ( {{ $product->product_code }} )
                                                </td>
                                                <td>{{ implode(', ' ,$product->services()->pluck('name')->toArray()) }}</td>
                                                <td>{{ implode(', ' ,$product->sub_category()->pluck('name')->toArray()) }}</td>
                                                <td>{{ $product->brand ?  $product->brand->name : null }}</td>
                                                <td>{{ number_format($product->price, 2) }}</td>
                                                <td>{{ number_format($product->discount_amount, 2) }}</td>
                                                <td></td>
                                                <td>{{ $product->status ? 'Active' : 'Not Active' }}</td>
                                                <td>
                                                    <a href="{{ route('product.edit', $product->slug) }}" class="text-success" data-original-title title><i class="material-icons">edit</i></a>
                                                    <a href="Javascript:void(0);" onclick="Product.removeProduct('{{ $product->slug }}')" class="text-danger" data-product-name="{{ ucwords($product->name) }}">
                                                        <i class="material-icons" data-original-title title>close</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>
<script>
var Product = {
    init : function() {
        this.initDataTable();
        this.initDatePicker();
    },
    initDataTable : function() {
        $("#table_product_list").dataTable();
    },
    initDatePicker : function() {
        $('.datepicker').datetimepicker({
                format: "YYYY-MM-DD",
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: "fa fa-chevron-left",
                    next: "fa fa-chevron-right",
                    today: "fa fa-screenshot",
                    clear: "fa fa-trash",
                    close: "fa fa-remove"
                }
            });
    },
    removeProduct : function(productId) {
        if(!confirm("Are You Sure Want Remove This Product"))
            return false;

        $.ajax({
            "url" : "/admin/product/" + productId,
            "type" : "DELETE",
            "dataType": "json",
            "success" : function(data) {
                    $("#row_" + productId).remove();
                    Product.updateSequenceNo();
                    toastr.success('Removed Successfully');
            },
            "error": function(jqXHR, exception) {
                    toastr.success('Sorry Cant remove now');
            }
        });
    },
    updateSequenceNo : function() {
        var sno = 1;
        $("#table_product_list").find(".product_sequence_no").each(function() {
                $(this).html(sno++);
        });
    }
};

$(document).ready(function() {
    Product.init();
});

</script>

@endsection
