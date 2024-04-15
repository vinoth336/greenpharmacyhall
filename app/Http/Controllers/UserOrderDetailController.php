<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderSendNotificationToAdmin;
use App\Mail\OrderCancelledSendNotificationToAdmin;
use App\OrderStatus;
use App\UserOrder;
use PDF;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserOrderDetailController extends Controller
{

    public function orderList()
    {
        $user = auth()->user();
        $pharmaOrders = $user->pharma_orders()->with(['order_status'])->orderBy('created_at', 'desc')->get();

        $nonPharmaOrders = $user->non_pharma_orders()->with(['ordered_items' => function($query) {
                $query->with([ 'product' => function($query) {
                        $query->with('ProductImages');
                }, 'media']);
        }, 'order_status'])->orderBy('created_at', 'DESC')->get();


        return view('public.user.orders')
        ->with('pharmaOrders', $pharmaOrders)
        ->with('nonPharmaOrders', $nonPharmaOrders)
        ;
    }

    public function orderCancel(Request $request, $order)
    {
        DB::beginTransaction();
        try {

            $order = UserOrder::authUser()->with('order_status')->where('order_no', $order)->firstOrFail();

            if($order->order_status->slug_name == 'pending') {
                $order->order_status_id = OrderStatus::where('slug_name', 'cancel')->first()->id;
                $order->save();
                $order->load('order_status');

                Mail::send(new OrderCancelledSendNotificationToAdmin(auth()->user(), $order));

                DB::commit();

                return response(['status' => true, 'message' => 'Cancelled Successfully'], 200);
            } else {
                return response(['status' => false, 'message' => "Can't Cancelled Order, Please Contact Admin"], 406);
            }

        } catch(ModelNotFoundException $e) {
            DB::rollback();
            info($e->getMessage());
            return response(['status' => false, 'message' => 'Invalid Request'], 404);
        }
        catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }
    }

    public function delete(Request $request, $order)
    {
        DB::beginTransaction();
        try {

            $order = UserOrder::authUser()->where('order_no', $order)->firstOrFail();

            if($order->order_status->slug_name == 'pending') {
                $order->delete();
                DB::commit();

                return response(['status' => true, 'message' => 'Removed Successfully'], 200);
            } else {
                return response(['status' => false, 'message' => "Can't Delete Order, Please Contact Admin"], 406);
            }

        } catch(ModelNotFoundException $e) {
            DB::rollback();
            info($e->getMessage());
            return response(['status' => false, 'message' => 'Invalid Request'], 404);
        }
        catch (Exception $e) {
            DB::rollback();
            info($e->getMessage());

            return response("Can't Process, Please Contact Admin", 500);
        }
    }

    public function download_invoice(Request $request, $order)
    {
        $order = UserOrder::authUser()->where('order_status_id', 2)->where('order_no', $order)->firstOrFail();
        $user = auth()->user();

        //return view('public.user.non_pharma_order_invoice', ['user' => $user, 'order' => $order]);
        $pdf = PDF::loadView('public.user.non_pharma_order_invoice', ['userDetail' => $user, 'order' => $order]);

        return $pdf->download('Invoice_' . $order->order_no . '.pdf');

    }

}
