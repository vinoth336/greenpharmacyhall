@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Enquiries')])

@section('content')

    <link rel="stylesheet" href="{{ asset('web/css/draganddrop.css') }}" type="text/css" />
    <style>
        .order_table th {
            background-color: #eee;
        }

    </style>
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
                            <h4 class="card-title float-left">{{ __('Pharma - Orders') }}</h4>
                        </div>
                        <?php $sno = 1; ?>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <form method="GET" accept="{{ route('pharma_orders.index') }}">
                                    <h5>Filter</h5>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-3 " style="margin-bottom: 10px">
                                            <select name="status" class="selectpicker form-control">
                                                    <option >All</option>
                                                @foreach($orderStatus as $status)
                                                    <option value='{{ $status->id }}' @if($status->id == request()->get('status')) selected @endif>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-3">
                                            From
                                            <input type="text" name="from_date" class="form-control datepicker"
                                                value="{{ old('from_date', request()->has('from_date') ? request()->input('from_date') : date('Y-m-01')) }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-3">
                                              To
                                            <input type="text" name="to_date" class="form-control datepicker"
                                                value="{{ old('to_date', request()->has('to_date') ? request()->input('to_date') :  date('Y-m-d')) }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-3">
                                            <button type="submit" name="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>

                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="datatables"
                                    class="table table-striped table-no-bordered table-hover dataTable dtr-inline">
                                    <thead class=" text-dark text-bold">
                                        <th>
                                            S NO
                                        </th>
                                        <th>
                                            Order No
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Phone No
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            On
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th class="text-center">
                                            Actions
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr id="order_{{ $order->id }}">
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ $order->order_no }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td><a href="tel:{{ $order->user->phone_no }}">{{ $order->user->phone_no }}</a></td>
                                                <td><a href="mail:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>
                                                    <a id="order_status_block_{{ $order->id }}"
                                                        style="cursor:pointer; color: #9c27b0" >
                                                        {{ strtoupper(optional($order->order_status)->name) }}
                                                    </a>
                                                </td>
                                                <td class="text-center ">
                                                        <a href="#" class="btn btn-link btn-warning btn-just-icon show view_order"
                                                        data-recordid="{{ $order->id }}"><i
                                                                class="material-icons">visibility</i></a>
                                                        <a title="Download Invoice" href="{{ route('user_orders.download_non_pharma_invoice', $order->id) }}" class="btn btn-link btn-info btn-just-icon show view_invoice_btn"
                                                                data-recordid="{{ $order->id }}">
                                                            <i class="material-icons">download</i>
                                                        </a>
                                                </td>
                                            </tr>

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

    <!-- Modal -->
    <div class="modal fade" id="updateOrderStatus" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('user_orders.index') }}" onsubmit="return updateStatus()">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="contact_person_name"></h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="printOrder()">Print</button>&nbsp;
                        <button type="submit" class="btn btn-primary" id="save_status">Save</button>&nbsp;
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ended -->
    <script>
        var imageUrl = "{{ config('app.url') }}/web/images/prescriptions/";
        $(document).ready(function() {
            $("#datatables").dataTable();
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
        });

        function updateStatus() {
            $.ajax({
                url: "/admin/user_orders/" + $("#updateOrderStatus").find("#order_id").val(),
                type: 'put',
                dataType: 'json',
                "data": {
                    'order_status': $("#updateOrderStatus").find("#orderStatus").val(),
                    'comment': $("#updateOrderStatus").find("#orderComment").val()
                },
                success: function(data) {
                    alert('Updated Successfully');
                    var order_block = $("#order_status_block_" + $("#order_id").val());
                    order_block.html($("#orderStatus").find("option:selected").text().toUpperCase());
                    $("#updateOrderStatus").modal('hide');

                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status == 422) {
                        alert(jqXHR.responseJSON.message);
                    } else {
                        alert('Something Went Wrong')
                    }

                }
            });

            return false;

        }

        $(".view_order").on('click', function() {
            $.ajax({
                url: "/admin/user_orders/" + $(this).data('recordid'),
                type: 'get',
                success: function(data) {
                    $("#updateOrderStatus").find('.modal-body').html(data);
                    $("#updateOrderStatus").modal('show');
                    $("#updateOrderStatus").find('.selectpicker').selectpicker();
                },
                error: function(jqXHR, exception) {
                    alert('Something Went Wrong')
                }
            })
        });

        function printOrder()
        {

            var mywindow = window.open('', 'Print Order', 'height=400,width=600');
            mywindow.document.write('<html><head><title></title>');
            mywindow.document.write('<link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />');
            mywindow.document.write('</head><body>');
            mywindow.document.write('<style> #update_order_status { display: none } body { padding: 5px;} </style>');
            mywindow.document.write($("#updateOrderStatus").find(".modal-body").html());
            mywindow.document.write('</body></html>');
            mywindow.document.close();
            mywindow.print();
        }


    </script>

@endsection
