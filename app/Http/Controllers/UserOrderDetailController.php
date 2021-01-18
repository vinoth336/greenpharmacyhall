<?php

namespace App\Http\Controllers;

use App\UserOrder;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserOrderDetailController extends Controller
{

    public function orderList()
    {
        $user = auth()->user();
        $pharmaOrders = $user->pharma_orders()->with('order_status')->orderBy('created_at', 'desc')->get();

        $nonPharmaOrders = $user->non_pharma_orders()->with(['ordered_items' => function($query) {
                $query->with([ 'product' => function($query) {
                        $query->with('ProductImages');
                }]);
        }, 'order_status'])->orderBy('created_at', 'DESC')->get();


        return view('public.user.orders')
        ->with('pharmaOrders', $pharmaOrders)
        ->with('nonPharmaOrders', $nonPharmaOrders)
        ;
    }

    public function delete(Request $request, UserOrder $order)
    {
        DB::beginTransaction();
        try {

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


}
