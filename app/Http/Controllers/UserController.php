<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCustomerPassword;
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

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        return view('public.user.change_password')->with('user', $user);
    }

    public function update(UpdateUserProfileRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();
            $user->name = $request->input('name');
            $user->sex = $request->input('sex');
            $user->address = $request->input('address');
            $user->email = $request->input('email');
            $user->zipcode = $request->input('zipcode');
            $user->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error Occurred in UserController@update - ' . $e->getMessage());

            return redirect()->route('public.index')->withErrors(['status' => 'Can\'t Process Request, Please Try Again']);
        }

        return view('public.user.dashboard')
            ->with('status', 'Profile Updated Successfully')
            ->with('user', $user)
        ;
    }

    public function updatePassword(UpdateCustomerPassword $request)
    {
        DB::beginTransaction();

        try {

            $user = auth()->user();
            if(!Hash::check($request->input('current_password'), auth()->user()->password)) {

                return redirect()->route('public.change_password')
                ->withErrors(['current_password' => 'Current Password Is Invalid']);
            }
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            DB::commit();

            return redirect()->route('public.change_password')
                ->with(['status' => 'Password Updated Successfully...']);

        } catch(Exception $e) {
            DB::rollback();
            Log::error('Error Occurred in UserController@updatePassword - ' . $e->getMessage());

            return redirect()->route('public.change_password')->withErrors(['error' => 'Can\'t Process Request, Please Try Again']);
        }
    }
}
