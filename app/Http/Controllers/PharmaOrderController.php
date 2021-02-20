<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePharmaOrderRequest;
use App\Mail\PharmaNewOrderSendNotificationToAdmin;
use App\OrderStatus;
use App\PharmaPrescription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PharmaOrderController extends Controller
{
    public function index()
    {
        return view('public.user.add_prescription');
    }

    public function create(CreatePharmaOrderRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();
            $createOrder = new PharmaPrescription();
            $image = $request->has('prescription') ? $request->file('prescription') : null;
            $createOrder->comment_text = $request->input('comment_text');
            $createOrder->user_id = $user->id;
            $createOrder->order_status_id = OrderStatus::where('slug_name', 'pending')->first()->id;
            $createOrder->storeImage($image);
            $createOrder->save();
            $order = PharmaPrescription::find($createOrder->id);
            Mail::send(new PharmaNewOrderSendNotificationToAdmin($user, $order));

            DB::commit();

            return redirect()->route('public.order_list');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error Occurred in UserController@update - ' . $e->getMessage());
            echo $e->getMessage();
            exit;
        }

        return redirect()->route('public.pharma_purchase_order');
    }

    public function orderList()
    {
        $user = auth()->user();
        $orders = $user->pharma_orders()->with('order_status')->orderBy('created_at', 'desc')->get();

        return view('public.user.pharma_orders')
        ->with('orders', $orders);
    }

    public function deleteOrder(Request $request, PharmaPrescription $order)
    {
        DB::beginTransaction();

        try {
            $order->unlinkImage($order->image);
            $order->delete();

            DB::commit();

            return redirect()->route('public.order_list');

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error Occurred in UserController@update - ' . $e->getMessage());
            echo 'Cant process';
            exit;
        }

        return redirect()->route('public.pharma_purchase_order');
    }

}
