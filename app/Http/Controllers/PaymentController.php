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
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );

        $user = auth()->user();
        if ($signatureStatus == true) {

            info("Signature status");

            info(print_r($signatureStatus, true));

            info("Payment capture");
            $api = new Api (env('RZR_KEY_ID'), env('RZR_KEY_SECRET'));
            $payment = $api->payment->fetch($request->input('rzp_paymentid'));
            $userOrder = UserOrder::where('order_no', $request->input('rzp_user_order_no'))->firstOrFail();
            // You can create this page
            Payment::create([
                'user_id' => $user->id,
                'order_id' => $request->input('rzp_orderid'),
                'payment_id' => $request->input('rzp_paymentid'),
                'payment_signature' => $request->input('rzp_signature'),
                'user_order_no' => $request->input('rzp_user_order_no'),
                'amount' => $request->input('amount'),
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
                'order_id' => $request->all()['rzp_orderid'],
                'payment_id' => $request->all()['rzp_paymentid'],
                'payment_signature' => $request->all()['rzp_signature'],
                'user_order_no' => $request->all()['rzp_user_order_no'],
                'amount' => $request->all()['amount'],
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
