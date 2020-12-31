<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\User;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        return view('public.user.dashboard')->with('user', $user);
    }

    public function update(UpdateUserProfileRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();
            $user->name = $request->input('name');
            $user->sex = $request->input('sex');
            $user->address = $request->input('address');
            $user->phone_no = $request->input('phone_no');
            $user->zipcode = $request->input('zipcode');
            $user->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error Occurred in UserController@update - ' . $e->getMessage());

            echo 'Cant process';
            exit;
           // return redirect()->route('public.index')->with(['status' => 'Can\'t Process Request, Please Try Again']);
        }

        return view('public.user.dashboard')
            ->with('status', 'Profile Updated Successfully')
            ->with('user', $user)
        ;
    }
}
