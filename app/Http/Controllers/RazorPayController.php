<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use App\Payment;
use App\Cart;
use Session;
use Exception;

class RazorPayController extends Controller
{
    public function index()
    {
        return view('razorpayView', [

        ]);
    }

    public function createOrder(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $results = $api->order->create([
            'receipt' => '123', 'amount' => 100, 'currency' => 'INR',
            'notes' => ['key1' => 'value3', 'key2' => 'value2']
        ]);
        $options = [
            "key" => config('services.razorpay.key'),
            "amount" => "1",
            "currency" => "INR",
            "name" => "Green Pharamacy Hall",
            "description" => "Test Transaction",
            "image" => "https://example.com/your_logo",
            "order_id" => $results['id'], //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "prefill" => [ //We recommend using the prefill parameter to auto-fill customer's contact information, especially their phone number
                "name" => "Gaurav Kumar", //your customer's name
                "email" => "gaurav.kumar@example.com",
                "contact" => "9715646356"  //Provide the customer's phone number for better conversion rates
            ],
            "notes" => [
                "address" => "Razorpay Corporate Office"
            ],
            "theme" => [
                "color" => "#3399cc"
            ]
        ];
        return view('razorpayView', [
            $options
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $api = new Api (env('RZR_KEY_ID'), env('RZR_KEY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $payment = Payment::create([
                    'r_payment_id' => $response['id'],
                    'method' => $response['method'],
                    'currency' => $response['currency'],
                    'user_email' => $response['email'],
                    'amount' => $response['amount'] / 100,
                    'json_response' => json_encode((array)$response)
                ]);
            } catch (Exception $e) {
                return $e->getMessage();
                Session::put('error', $e->getMessage());
                return redirect()->back();
            }
        }
        //Session::put('success',('Payment Successful');
        return redirect()->back();
    }

    public function paymentComplete(Request $request)
    {
        $user = auth()->user();
// Now verify the signature is correct . We create the private function for verify the signature
        $signatureStatus = $this->SignatureVerify(
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );
        // If Signature status is true We will save the payment response in our database
        // In this tutorial we send the response to Success page if payment successfully made
        if ($signatureStatus == true) {
            // You can create this page
            Payment::create([
                'user_id' => $user->id,
                'order_id' => $request->all()['rzp_orderid'],
                'payment_id' => $request->all()['rzp_paymentid'],
                'payment_signature' => $request->all()['rzp_signature'],
                'amount' => $request->all()['amount'],
                'status' => 'Paid'
            ]);
            Cart::where('user_id', $user->id)->update([
                'status' => 0
            ]);
            return redirect()->route('public.order_list');
        } else {
            // You can create this page
            Payment::create([
                'user_id' => $user->id,
                'order_id' => $request->all()['rzp_orderid'],
                'payment_id' => $request->all()['rzp_paymentid'],
                'payment_signature' => $request->all()['rzp_signature'],
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
