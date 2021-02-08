<?php

namespace App\Http\Controllers;

use App\CustomerChangePasswordRequest;
use App\Http\Requests\UpdateForgotPasswordRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequestController extends Controller
{
    public $status = [
        'pending' => 'Pending',
        'contact' => 'Contact',
        'reset_password' => 'Reset Password',
        'password_changed' => 'Password Changed',
        'cancel' => 'Cancel',
        'fake' => 'Fake'
    ];

    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $passwordRequest = CustomerChangePasswordRequest::with('user')->OrderBy('created_at');
        if ($request->has('status')) {
            if (!in_array($request->input('status'), ['All', 'all', ''])) {
                $passwordRequest->where('status', $request->input('status'));
            }
        }

        if ($request->has('request_type')) {
            if (!in_array($request->input('request_type'), ['All', 'all', ''])) {
                $passwordRequest->where('request_type', $request->input('request_type'));
            }
        }


        if ($request->input('from_date') && $request->input('to_date')) {
            $startDate = date("Y-m-d 00:00:00", strtotime($request->input('from_date')));
            $endDate   = date("Y-m-d 23:59:59", strtotime($request->input('to_date')));
            $passwordRequest->whereBetween("created_at", array($startDate, $endDate));
        }

        return view('forgot_password.list', ['CustomerChangePasswordRequest' => $passwordRequest->get(), 'request_status' => $this->status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerChangePasswordRequest $changePasswordRequest)
    {

        $response = [
            'id' => $changePasswordRequest->id,
            'name' => $changePasswordRequest->user->name,
            'phone_no' => $changePasswordRequest->user->phone_no,
            'email' => $changePasswordRequest->user->email,
            'status' => $changePasswordRequest->status,
            'comment' => $changePasswordRequest->comment,
            'created_at' => $changePasswordRequest->created_at
        ];

        return $response;;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForgotPasswordRequest $request, CustomerChangePasswordRequest $changePasswordRequest)
    {
        DB::beginTransaction();
        $message = 'Updated Successfully';
        try {
            $changePasswordRequest->status = $request->input('status');
            $changePasswordRequest->comment = $request->input('comment');
            if($changePasswordRequest->status == 'reset_password') {
                $user = $changePasswordRequest->user;
                $user->password = Hash::make($user->phone_no);
                $user->save();
                $changePasswordRequest->status = 'password_changed';
                $message = 'Password was reset successfully, Please note new password is customer Phone No';
            }
            $changePasswordRequest->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return response(['status' => false, 'message' => $e->getMessage()], SERVER_ERROR);
        }

        return response(['message' => $message , 'status_value' => $this->status[$changePasswordRequest->status]], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerChangePasswordRequest $changePasswordRequest)
    {
        DB::beginTransaction();
        try {
            $changePasswordRequest->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return response(['status' => false, 'message' => $e->getMessage()], SERVER_ERROR);
        }

        return redirect()->route('change_password_request.index')->with('status', 'Removed Successfully');
    }
}
