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
                                                value="{{ old('to_date', request()->has('to_date') ? request()->input('from_date') :  date('Y-m-d')) }}">
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
                                            Name
                                        </th>
                                        <th>
                                            Comment
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
                                        <th>
                                            Actions
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr id="order_{{ $order->id }}">
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->comment_text }}</td>
                                                <td><a href="tel:{{ $order->user->phone_no }}">{{ $order->user->phone_no }}</a></td>
                                                <td><a href="mail:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>
                                                    <a id="order_status_block_{{ $order->id }}"
                                                        style="cursor:pointer; color: #9c27b0" class="view_enquiry"
                                                        data-recordid="{{ $order->id }}">
                                                        {{ strtoupper(optional($order->order_status)->name) }}
                                                    </a>
                                                </td>
                                                <td class="text-right ">
                                                        <a href="#" class="btn btn-link btn-warning btn-just-icon show"><i
                                                                class="material-icons">eye</i></a>
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
                <form method="POST" action="{{ route('pharma_orders.index') }}" onsubmit="return updateStatus()">

                    <input type="hidden" id="order_id" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="contact_person_name"></h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered order_table">
                            <tbody>
                                <tr>
                                    <th class="">Created On</th>
                                    <td id="order_created_on"></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td id="order_user_name"></td>
                                </tr>
                                <tr id="prescription_section">
                                    <th>Prescription</th>
                                    <td id="order_prescription" style="text-align: justify; line-height:12px">
                                            <a href="" id="order_prescription_url" target="_blank">
                                                View
                                            </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td id="order_user_address">
                                    </td>
                                <tr>
                                    <th>Phone No</th>
                                    <td id="order_user_phone_no"></td>
                                </tr>
                                <tr>
                                    <th>Email Id</th>
                                    <td id="order_user_email_id"></td>
                                </tr>
                                <tr id="update_order_status">
                                    <th>Status</th>
                                    <td>
                                        <select id="orderStatus" name="order_status" class="selectpicker">
                                            @foreach ($orderStatus as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Comment</th>
                                    <td id="order_user_comment_text">
                                        {{ __('Comment') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                url: "/admin/pharma_orders/" + $("#order_id").val(),
                type: 'put',
                dataType: 'json',
                "data": {
                    'order_status': $("#orderStatus").val(),
                    'comment': $("#order_comment").val()
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

        $(".view_enquiry").on('click', function() {

            $.ajax({
                url: "/admin/pharma_orders/" + $(this).data('recordid'),
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $("#order_id").val(data.id);
                    $("#order_user_name").html(data.user.name);
                    $("#order_created_on").html(data.created_at);
                    $("#order_user_address").html(data.user.address);
                    $("#order_user_phone_no").html(data.user.phone_no);
                    $("#order_User_email_id").html(data.user.email);
                    $("#order_prescription_url").attr('href', "" + imageUrl + data.image);
                    $("#orderStatus").val(data.order_status_id);
                    $("#orderStatus").trigger('change');
                    $("#order_user_comment").html(data.comment);
                    $("#updateOrderStatus").modal('show');


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
            mywindow.document.write('<style> #update_order_status, #prescription_section { display: none } body { padding: 5px;} </style>');
            mywindow.document.write($("#updateOrderStatus").find(".modal-body").html());
            mywindow.document.write('</body></html>');
            mywindow.document.close();
            mywindow.print();
        }

    </script>

@endsection
