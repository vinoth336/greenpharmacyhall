<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;

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
