<?php

namespace App\Http\Controllers;

use App\CustomerChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerForgotPasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserLoginController extends Controller
{

    public function showLoginForm()
    {
        return view('public.auth.login');
    }

    public function login(UserLoginRequest $request)
    {
        if (Auth::guard('web')->attempt($request->only('phone_no', 'password'), $request->filled('remember'))) {
            //Authentication passed...
            $redirectTo = route('home');
            if($request->has('redirectTo')) {
                if($request->get('redirectTo') == 'checkout') {
                    $redirectTo = route('public.cart.checkout');
                }
            }
            return redirect()
                 ->intended($redirectTo);
        }

        //Authentication failed...
        return $this->loginFailed();
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()
            ->route('home');
    }

    private function loginFailed(){
        return redirect()
            ->back()
            ->withInput()
            ->with('login_failed','Login failed, please try again!');
    }

    public function forgotPassword(CustomerForgotPasswordRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::where('phone_no', $request->get('forgot_password_phone_no'))->first();
            $changePasswordRequest = new CustomerChangePasswordRequest();
            $changePasswordRequest->user_id = $user->id;
            $changePasswordRequest->status = 'pending';
            $changePasswordRequest->request_type = 'change_password';
            $changePasswordRequest->save();

            DB::commit();

            return redirect()
            ->route('home')
            ->withInput()
            ->with('login_success','Your Request Submitted Successfully');

        } catch(Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            die('error' . $e->getMessage());
            return redirect()
            ->route('home')
            ->with(['login_failed' => "Can't Process Request"], SERVER_ERROR);
        }


    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'username'    => 'required|username|exists:members,username',
            'password' => 'required|string|min:4|max:255',
        ];

        //validate the request.
        $request->validate($rules);
    }
}
