<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemListResponse;
use App\Mail\NewOrderSendNotificationToAdmin;
use App\UserOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;

class UserOrderController extends Controller
{

    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $items =  $user->cart()->with(["product" => function ($query) {
            }])->where('status', 1)->get();

            if ($items->count() <= 0) {
               return response(['status' => false, "message" => "Please confirm the selected items to process"], 400);
            }

            $userOrder = UserOrder::create([
                'user_id' => $user->id,
                'order_no' => orderNumber(),
                'order_status_id' => 1
            ]);

            $sum = 0;
            foreach ($items as $item) {
                $userOrder->ordered_items()->create([
                    'user_id' => $user->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->actual_price,
                ]);
                $sum += $item->qty * $item->product->actual_price;
                $item->delete(); //Remove from cart
            }

            $userOrder->total_amount = $sum;
            $userOrder->delivery_type = $request->input('delivery_type') == 'door_delivery' ? 1 : 2;
            $userOrder->save();
            // Check online or offline call payment 
            $paymentData=[
                'amount'=>$sum,
                'prefill'=>[
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'contact'=>$user->phone_no
                ],
                'receipt'=>strtotime(time())
            ];
            $paymentOrders=$this->initiatePayment($paymentData);
            $delivery_type = $request->input("delivery_type");
            $cartSettings = Cache::get('cart_settings');

            if($delivery_type == 'door_delivery' && $sum < $cartSettings['free_deliver_min_amt'] ) {
                DB::rollback();
                return response("MIN ORDER AMOUNT For Free Delivery Is " . number_format($cartSettings['free_deliver_min_amt'], 2) , NOT_ACCEPTABLE);
            } elseif($sum < $cartSettings['shop_pickup_min_amt'] ) {
                DB::rollback();
                return response("MIN ORDER AMOUNT For Shop Pickup Is " . number_format($cartSettings['shop_pickup_min_amt'], 2) , NOT_ACCEPTABLE);
            }
            $userOrder->load('order_status');

        //    Mail::send(new NewOrderSendNotificationToAdmin($user, $userOrder));

            DB::commit();
           // dd($paymentOrders);
            return response()->json([$paymentOrders]);

        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            info($e->getMessage());
            return response("Can't Process, Please Contact Admin", SERVER_ERROR);
        }

        return response(['status' => true, "message" => 'Successfully Ordered Placed']);
    }

    public function getCartItems()
    {
        $user = auth()->user();
        $items =  $user->cart()->with( ["product" => function($query) {
            $query->with('ProductImages');
        }])->get();

        return $items;
    }
    private function initiatePayment($paymentData){
       
        $api = new Api(config('services.razorpay.key'),config('services.razorpay.secret'));

        $results=$api->order->create(array('receipt' => (string)$paymentData['receipt'], 'amount' => (int) ($paymentData['amount']*100), 'currency' => 'INR', 'notes'=> array('key1'=> 'value3','key2'=> 'value2')));
     $options = [
            "key"=> config('services.razorpay.key'),
            "amount"=> (int)($paymentData['amount']*100), 
            "currency"=> "INR",
            "name"=> "Green Pharamacy Hall",
            "description"=> "Test Transaction",
            "image"=> "https://example.com/your_logo",
            "order_id"=> $results['id'], //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "prefill"=> $paymentData['prefill'],
            "notes"=> [
                "address"=> "Razorpay Corporate Office"
            ],
            "theme"=> [
                "color"=> "#3399cc"
            ]
        ];
        return $options;
    }
}
