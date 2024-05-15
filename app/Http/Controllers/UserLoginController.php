<?php

namespace App\Http\Controllers;

use App\CustomerChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerForgotPasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\User;
use App\Otps;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserLoginController extends Controller
{

    public function showLoginForm()
    {
        return view('public.auth.login');
    }

    public function login(UserLoginRequest $request){
        $user = User::where('phone_no', $request->input('phone_no'))->first();
        if ($user) {
            $otp=$this->generateOtp($request->input('phone_no'));
            if (env('APP_ENV') == 'production') {
                $otp=$this->generateOtp($request->input('phone_no'));
                Otps::sendSMS($request->input('phone_no'),$otp);
            } else {
                $otp=$this->generateOtp($request->input('phone_no'));
            }
            return response()->json(['msg' => 'OTP Send Successfully'], 200);
        } else {
            return response()->json(['msg' => 'User not found'], 404);
        }
    }
    public function regenerateOtp(UserLoginRequest $request){
        //Remove the otp
        $otp=Otps::where('phone_number',$request->get('phone_no'))->first();
        $otp->delete();
        // Regenerate OTP
        $otp=$this->generateOtp($request->input('phone_no'));
        Otps::sendSMS($request->input('phone_no'),$otp);
        return response()->json(['msg' => 'OTP Send Successfully'], 200);
    }
    public function verifyOtp(Request $request){
        $otp=Otps::where('phone_number',$request->get('phone_no'))->first();
        if(!$otp || $otp->otp!==$request->get('otp') || $otp->expires_at<now()){
            return response()->json(['error' => 'Invalid OTP'], 401);
        }else{
            $user = User::where('phone_no', $request->input('phone_no'))->first();
              Auth::login($user);
        $otp->delete();
        $redirectTo = '/';
        if($request->has('redirectTo')) {
            if($request->get('redirectTo') == 'checkout') {
                $redirectTo = '/cart/checkout/';
            }
        }
        return response()->json(['route'=>$redirectTo],200);
    }
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()
            ->route('home');
    }

    private function loginFailed($msg = 'Login failed, please try again!'){
        return redirect()
            ->back()
            ->withInput()
            ->with('login_failed', $msg);
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
    public function generateOtp($phoneNumber){
    // Generate OTP
    $otpNumber= env('APP_ENV') == 'production' ? mt_rand(100000,999999) : '123456';
    $otpsModel=Otps::firstOrCreate(
        [
            'phone_number'=>$phoneNumber
        ],
        [
           'phone_number'=>$phoneNumber,
           'otp'=>$otpNumber,
           'expires_at'=>now()->addMinutes(5)
        ]
    );
    return $otpsModel->otp;
    }
}
