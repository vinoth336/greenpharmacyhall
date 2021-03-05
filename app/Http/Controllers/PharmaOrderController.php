<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePharmaOrderRequest;
use App\Mail\PharmaNewOrderSendNotificationToAdmin;
use App\Mail\SendOrderNotificationToAdmin;
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
            $prescription = $request->has('prescription') ? $request->file('prescription') : null;
            $createOrder->comment_text = $request->input('comment_text');
            $createOrder->user_id = $user->id;
            $createOrder->order_status_id = OrderStatus::where('slug_name', 'pending')->first()->id;
            $createOrder->storeImage($prescription);
            $createOrder->save();
            $order = PharmaPrescription::find($createOrder->id);
            Mail::send(new PharmaNewOrderSendNotificationToAdmin($user, $createOrder));
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

    public function OrderCancel(Request $request, PharmaPrescription $order)
    {
        DB::beginTransaction();

        try {
            if ($order->order_status->slug_name == 'pending') {
                $order->order_status_id = OrderStatus::where('slug_name', 'cancel')->first()->id;
                $order->save();

                DB::commit();

                return redirect()->route('public.order_list');
            } else {
                return response(['status' => false, 'message' => "Can't Cancelled Order, Please Contact Admin"], 406);
            }
        } catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }

        return redirect()->route('public.pharma_purchase_order');
    }

    public function deleteOrder(Request $request, PharmaPrescription $order)
    {
        DB::beginTransaction();

        try {
            $order->order_status_id = OrderStatus::where('slug_name', 'cancel')->first()->id;
            $order->save();

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
