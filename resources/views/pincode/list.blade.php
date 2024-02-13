@extends('layouts.app', ['activePage' => 'typography', 'titlePage' => __('Pincode Master')])
@section('content')

<div class="content">
<div class="container-fluid">
    <div class="row">
    <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title float-left">{{ __('Pincode') }}</h4>
                        <a href="{{ route('product.create') }}" class="btn btn-success float-right"><i class="material-icons">add</i></a>

                        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown" style="margin-right: 10px;margin-top: 5px !important;">
                            <div class="btn-group" role="group">
                              <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Import
                              </button>
                              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="{{ route('pincode.import_pincode') }}">Import Pincode</a>
                              </div>
                            </div>
                        </div>
                        <a href="{{ route('product.export') }}" class="btn btn-info float-right" style="margin-right: 10px;margin-top: 5px !important;">
                            Export Xls
                        </a>

                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">

                            <table id="table_product_list" class="table table-striped table-no-bordered table-hover dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>S NO</th>
                                        <th>Pincode</th>
                                        <th>Estimated Delivery Days</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark text-bold">
                                    @php
                                        $sno = 1;
                                    @endphp
                                    @foreach ($pincodes as $pincode )
                                        @if(!empty($pincode))
                                            <tr id="row_{{ $pincode->id }}">
                                                <td class="product_sequence_no">{{ $sno++ }}
                                                <td>{{$pincode->pincode}}</td>
                                                <td>
                
                                                    @foreach ($pincode->DeliveryEstimations as $object)
                                                        <span>{{ $object->min }} Days - {{ $object->min }} Days</span>
    <!-- Add more properties as needed -->
@endforeach
                                                </td>
                                                <td>
                                                    <a href="{{ route('product.edit', $pincode->id) }}" class="text-success" data-original-title title><i class="material-icons">edit</i></a>
                                                    <a href="Javascript:void(0);" onclick="Product.removeProduct('{{ $pincode->id }}')" class="text-danger" data-product-name="{{ ucwords($pincode->pincode) }}">
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
@endsection
