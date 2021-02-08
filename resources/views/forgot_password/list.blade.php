@extends('layouts.app', ['activePage' => 'forgot_password', 'titlePage' => __('Typography')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title float-left">{{ __('Change Password Requests') }}</h4>
                        </div>
                        <?php $sno = 1; ?>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <form method="GET" accept="{{ route('enquiries.index') }}">
                                        <h5>Filter</h5>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-3 " style="margin-bottom: 10px">
                                                <select name="status" class="selectpicker form-control">
                                                    <option>All</option>
                                                    @foreach ($request_status as $key => $status)
                                                        <option value='{{ $key }}' @if ($key == request()->get('status')) selected @endif>
                                                            {{ $status }}
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
                                                    value="{{ old('to_date', request()->has('to_date') ? request()->input('to_date') : date('Y-m-d')) }}">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-3">
                                                <button type="submit" name="submit" class="btn btn-primary">Search</button>
                                                <a href="{{ route('change_password_request.index') }}"
                                                    class="btn btn-danger">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-stripped" id="datatables">
                                    <thead class=" text-primary">
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
                                        @forelse ($CustomerChangePasswordRequest as $forgotPassword)
                                            <tr id="forgot_password_row_{{ $forgotPassword->id }}">
                                                <td>{{ $sno++ }}</td>
                                                <td>{{ $forgotPassword->user->name }}</td>
                                                <td><a
                                                        href="tel:{{ $forgotPassword->user->phone_no }}">{{ $forgotPassword->user->phone_no }}</a>
                                                </td>
                                                <td><a
                                                        href="mail:{{ $forgotPassword->user->email }}">{{ $forgotPassword->user->email }}</a>
                                                </td>
                                                <td>{{ $forgotPassword->created_at }}</td>
                                                <td>
                                                    @if ($forgotPassword->getOriginal('status') == 'password_changed')
                                                        {{ strtoupper($forgotPassword->requestStatus) }}
                                                    @else
                                                        <a id="forgot_password_status_block_{{ $forgotPassword->id }}"
                                                            style="cursor:pointer; color: #9c27b0" class="view_forgot_password"
                                                            data-recordid="{{ $forgotPassword->id }}">
                                                            {{ strtoupper($forgotPassword->requestStatus) }}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <form method="post"
                                                        action="{{ route('change_password_request.destroy', $forgotPassword->id) }}"
                                                        onsubmit="return confirm('Are You Sure, Want to delete this ?')">
                                                        @csrf
                                                        @method('delete')
                                                        <a href="#" class="btn btn-link btn-warning btn-just-icon show"><i
                                                                class="material-icons">eye</i></a>
                                                        <button type="submit"
                                                            class="btn btn-link btn-danger btn-just-icon remove"><i
                                                                class="material-icons">close</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty

                                        @endforelse
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
    <div class="modal fade" id="updateEnquiryStatus" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('faqs.index') }}" onsubmit="return updateStatus()">

                    <input type="hidden" id="forgot_password_id" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="contact_person_name"></h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered forgot_password_table">
                            <tbody>
                                <tr>
                                    <th class="">On</th>
                                    <td id="forgot_password_created_on"></td>
                                </tr>
                                <tr>
                                    <th>User Name</th>
                                    <td id="forgot_password_user_name"></td>
                                </tr>
                                <tr>
                                    <th>Phone No</th>
                                    <td id="forgot_password_phone_no"></td>
                                </tr>
                                <tr>
                                    <th>Email Id</th>
                                    <td id="forgot_password_email_id"></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <select id="forgot_password_status" name="status" class="selectpicker">
                                            <option value='pending'>Pending</option>
                                            <option value='contact'>Contact</option>
                                            <option value='reset_password'>Reset Password</option>
                                            <option value='fake'>Fake</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Comment</th>
                                    <td>
                                        <textarea class="form-control" name="comment" id="forgot_password_comment"
                                            placeholder="{{ __('Comment') }}" required></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save_status">Save</button>&nbsp;
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ended -->

    <script>
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
            var forgotPasswordId = $("#forgot_password_id").val();
            var status = $("#forgot_password_status").val();

            $.ajax({
                "url": "/admin/change_password_request/" + forgotPasswordId,
                "type": "put",
                "dataType": "json",
                "data": {
                    'status': status,
                    'comment': $("#forgot_password_comment").val()
                },
                "success": function(data) {
                    toastr.success(data.message);
                    if (data.status_value == 'Password Changed') {
                        $("#forgot_password_row_" + forgotPasswordId).find(".view_forgot_password")
                            .closest('td').html((data.status_value).toUpperCase());
                    } else {
                        $("#forgot_password_row_" + forgotPasswordId).find(".view_forgot_password").html(data
                            .status_value)
                    }
                    $("#updateEnquiryStatus").modal('hide');

                },
                "error": function(jqXHR, response) {
                    if (jqXHR.status == 404) {
                        toastr.error('Invalid Data');
                    } else {
                        toastr.error(jqXHR.responseText);
                    }
                }
            });

            return false;

        }


        $(".view_forgot_password").on('click', function() {

            $.ajax({
                url: "/admin/change_password_request/" + $(this).data('recordid'),
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $("#forgot_password_id").val(data.id);
                    $("#forgot_password_user_name").html(data.name);
                    $("#forgot_password_created_on").html(data.created_at);
                    $("#forgot_password_phone_no").html(data.phone_no);
                    $("#forgot_password_email_id").html(data.email);
                    $("#forgot_password_status").val(data.status);
                    $("#forgot_password_status").trigger('change');
                    $("#forgot_password_comment").val(data.comment);
                    $("#updateEnquiryStatus").modal('show');


                },
                error: function(jqXHR, exception) {
                    alert('Something Went Wrong')
                }
            })
        });

    </script>

@endsection
