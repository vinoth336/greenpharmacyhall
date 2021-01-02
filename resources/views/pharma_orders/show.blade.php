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


                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title float-left">{{ __('Enquiries') }}</h4>
                        </div>
                        <?php
                            $sno = 1;
                        ?>
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <th>
                                            S NO
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Subject
                                        </th>
                                        <th>
                                            Message
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
                                        @foreach ($orders as $order )
                                            <tr>
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->comment_text }}</td>
                                                <td>{{ $order->message }}</td>
                                                <td><a href="tel:{{ $order->phone_no }}">{{ $order->phone_no }}</a></td>
                                                <td><a href="mail:{{ $order->email }}">{{ $order->email }}</a></td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>{{ $order->status }}<i class="material-icons">pencil</i></td>
                                                <td class="text-right">
                                                    <a href="#" class="btn btn-link btn-warning btn-just-icon show"><i class="material-icons">eye</i></a>
                                                    <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i><div class="ripple-container"></div></a>
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
    <script>
        function updateStatus(enquiries_id, status) {
            $.ajax({
                "url": "/admin/orders/" + enquiries_id,
                "type": "put",
                "dataType": "json",
                "data": {
                    'status': status
                },
                "success": function(data) {
                    alert("Update Successfully");
                }
            });

        }

    </script>

@endsection
