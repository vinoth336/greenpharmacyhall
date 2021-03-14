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

            Mail::send(new NewOrderSendNotificationToAdmin($user, $userOrder));

            DB::commit();

            return CartItemListResponse::collection($this->getCartItems());

        } catch (Exception $e) {
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
            $query->with('ProductImages')   ;
        }])->get();

        return $items;
    }
}
