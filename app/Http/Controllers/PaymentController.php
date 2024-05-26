<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Payment;
use App\UserOrder;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function paymentComplete(Request $request)
    {
        $signatureStatus = $this->SignatureVerify(
            $request->all()['razorpay_signature'],
            $request->all()['razorpay_payment_id'],
            $request->all()['razorpay_order_id']
        );

        $user = auth()->user();
        if ($signatureStatus == true) {
            $api = new Api (env('RZR_KEY_ID'), env('RZR_KEY_SECRET'));
            $payment = $api->payment->fetch($request->input('razorpay_payment_id'));
            $userOrder = UserOrder::where('order_no', $request->input('razorpay_order_id'))->firstOrFail();
            // You can create this page
            Payment::create([
                'user_id' => $user->id,
                'order_id' => $request->input('razorpay_order_id'),
                'payment_id' => $request->input('razorpay_payment_id'),
                'payment_signature' => $request->input('razorpay_signature'),
                'user_order_no' => $request->input('razorpay_order_id') ?? 123,
                'amount' => $payment->amount / 100,
                'status' => 'Paid'
            ]);
            Cart::where('user_id', $user->id)->update([
                'status' => 0
            ]);
            return redirect()->route('public.order_list')->with(["message" => 'Order Placed Successfully', 'clear_cart' => true]);
        } else {
            // You can create this page
            Payment::create([
                'user_id' => $user->id,
                'order_id' => $request->all()['razorpay_order_id'],
                'payment_id' => $request->all()['razorpay_payment_id'],
                'payment_signature' => $request->all()['razorpay_signature'],
                'user_order_no' => $request->all()['razorpay_order_id'],
                'amount' =>  $payment->amount / 100,
                'status' => 'Failed'
            ]);
            // You can create this page
            return view('payment-failed-page');
        }
    }

    private function SignatureVerify($_signature, $_paymentId, $_orderId)
    {
        try {
// Create an object of razorpay class
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $attributes = array('razorpay_signature' => $_signature, 'razorpay_payment_id' => $_paymentId, 'razorpay_order_id' => $_orderId);
            $order = $api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
// If Signature is not correct its give a excetption so we use try catch
            return false;
        }
    }
}
