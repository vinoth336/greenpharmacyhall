@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Users')])

@section('content')
    <style>
        .user_table th {
            background-color: #eee;
        }

    </style>
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
                            <h4 class="card-title float-left">{{ __('Users') }}</h4>
                            <a href="{{ route('users.export') }}" class="btn btn-info float-right" style="margin-right: 10px;margin-top: 5px !important;">
                                Export Xls
                            </a>
                        </div>
                        <?php $sno = 1; ?>
                        <div class="card-body ">
                            <div class="row d-none">
                                <div class="col-md-12 col-lg-12">
                                    <form method="GET" accept="">
                                    <h5>Filter</h5>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-3 " style="margin-bottom: 10px">
                                            <select name="status" class="selectpicker form-control">
                                                    <option >All</option>
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
                                    class="table table-striped table-no-busered table-hover dataTable dtr-inline">
                                    <thead class=" text-dark text-bold">
                                        <th>
                                            S NO
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
                                            Sex
                                        </th>
                                        <th>
                                            Is Active
                                        </th>
                                        <th>
                                            On
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr id="user_{{ $user->phone_no }}">
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ ucfirst($user->name) }}</td>
                                                <td><a href="tel:{{ $user->phone_no }}">{{ $user->phone_no }}</a></td>
                                                <td><a href="mail:{{ $user->email }}">{{ $user->email }}</a></td>
                                                <td>{{ ucfirst($user->sex) }}</td>
                                                <td class="user_status">{{ $user->isActiveUser() ? 'Active' : 'In Active' }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td class="text-right ">
                                                    <a data-recordid="{{ $user->phone_no }}" href="#" class="btn btn-link btn-warning btn-just-icon view_user">
                                                        <i class="material-icons">visibility</i>
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
    <div class="modal fade" id="viewUser" role="dialog">
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

        function updateStatus(id) {
            $.ajax({
                url: "/admin/users/" + id,
                type: 'put',
                dataType: 'json',
                data: {
                    'active_status': $("#viewUser").find("#site_user_status").is(":checked") ? 1 : 0,
                },
                success: function(data) {
                    alert('Updated Successfully');
                    $("#user_" + id).find('.user_status').html(data.active_status);
                    $("#viewUser").modal('hide');
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

        $(".view_user").on('click', function() {
            $.ajax({
                url: "/admin/users/" + $(this).data('recordid'),
                type: 'get',
                success: function(data) {
                    $("#viewUser").find('.modal-body').html(data);
                    $("#viewUser").modal('show');
                    $("#viewUser").find('.selectpicker').selectpicker();
                },
                error: function(jqXHR, exception) {
                    alert('Something Went Wrong')
                }
            })
        });

    </script>
@endsection
