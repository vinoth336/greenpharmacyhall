<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Mail\SendRegistrationEmailVerification;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserRegistrationController extends Controller
{
    //

    public function index()
    {
        return view('public.auth.registration');
    }

    public function create(UserRegistrationRequest $request)
    {

        DB::beginTransaction();

        try {
            $user = User::create([
            'name' => $request->input('name'),
            'sex' => $request->input('sex'),
            'phone_no' => $request->input('phone_no'),
            'address' => $request->input('address'),
            'city_id' => 1,
            'state_id' => 2,
            'zipcode' => $request->input('zipcode'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
            ]);

            DB::commit();

            Auth::guard('web')->loginUsingId($user->phone_no);
            $redirectTo = route('public.dashboard');
            $message = ['status' => 'You are Logged in Successfully!'];
            if($request->has('redirectTo')) {
                $redirectTo = route('public.cart.checkout');
                $message['checkout_show_address_info'] = true;
            }

            return redirect()->intended($redirectTo)
            ->with($message);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error Occurred in UserRegistraionController@save - ' . $e->getMessage());

            echo 'Cant process';
           // return redirect()->route('public.index')->with(['status' => 'Can\'t Process Request, Please Try Again']);
        }

    }

    public function registerationSuccess(Request $request, $hash)
    {
        try
        {
            $email = decrypt($hash);
            $memberRegistrationRequest = User::findOrFail($email);
            $url = route('public.verify_email', $hash);

            if($memberRegistrationRequest->email_verified_at) {
                return redirect()->route('public.login')->with('status', 'Email Verified Successfully, Please login to continue the process');
            }

            return view('public.auth.registration_success')
            ->with(['hash' => $hash]);

        } catch (ModelNotFoundException $e) {
            return abort(404);
        } catch (Exception $e) {
            Log::error('Error Occurred in UserRegistrationController@registerationSuccess - ' . $e->getMessage());
            return abort(500);
        }

    }

    public function resendEmailVerification(Request $request)
    {
        try{
            $hash = $request->input('hash');
            $email = decrypt($hash);
            $memberRegistrationRequest = User::findOrFail($email);

            if($memberRegistrationRequest->email_verified_at) {
                return redirect()->route('public.login')->with('status', 'Email Verified Successfully, Please login to continue the process');
            }

            $this->sendVerificationEmail($memberRegistrationRequest);

            return redirect()->route('public.registration_success', $hash)
            ->with([
                'status' => 'Registered Successfully, Please check your mail for the next process',
                'hash' => $hash,
                'resent' => true
            ]);

        } catch (ModelNotFoundException $e) {
            return abort(404);
        } catch (Exception $e) {
            Log::error('Error Occurred in UserRegistraionController@resendEmailVerification - ' . $e->getMessage());
            return abort(500);
        }

    }

    public function verifyEmail(Request $request, $hash)
    {
        DB::beginTransaction();
        try{
            $email = decrypt($hash);
            $memberRegistrationRequest = User::findOrFail($email);
            if(!$memberRegistrationRequest->email_verified_at) {
                $memberRegistrationRequest->email_verified_at = now();
                $memberRegistrationRequest->save();

                DB::commit();

            } else {
                return view('public.auth.account_verified');
            }

            return redirect()->route('public.login')->with('status', 'Email Verified Successfully, Please login to continue the process');
        } catch (ModelNotFoundException $e) {
            return abort(404);
        } catch (Exception $e) {
            Log::error('Error Occurred in UserRegistraionController@verifyEmail - ' . $e->getMessage());
            return abort(500);
        }
    }

    public function sendVerificationEmail($user)
    {
        return Mail::send(new SendRegistrationEmailVerification($user));
    }
}
