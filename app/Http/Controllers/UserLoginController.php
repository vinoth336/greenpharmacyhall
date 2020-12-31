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
        if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            //Authentication passed...
            $user = auth()->user();
            if(!$user->email_verified_at) {
                Auth::logout();
                 //Authentication failed...
                return $this->loginFailed();
            }

            return redirect()
                 ->intended(route('public.dashboard'))
                 ->with('status', 'You are Logged in Successfully!');
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
            ->with('error','Login failed, please try again!');
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
