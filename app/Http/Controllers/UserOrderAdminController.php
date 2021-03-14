<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePharmaOrderStatusRequest;
use App\OrderStatus;
use App\UserOrder;
use PDF;
use Illuminate\Http\Request;

class UserOrderAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_users')->except('store');
    }

    public function index(Request $request)
    {

        $orders = UserOrder::with(['ordered_items' => function ($query) {
            $query->with(['product' => function ($query) {
                $query->with('ProductImages');
            }]);
        }, 'order_status'])->orderBy('created_at', 'DESC');
        if ($request->has('status')) {
            if (!in_array($request->input('status'), ['All', 'all', ''])) {
                $orders->where('order_status_id', $request->input('status'));
            }
        }

        if ($request->input('from_date') && $request->input('to_date')) {
            $startDate = date("Y-m-d 00:00:00", strtotime($request->input('from_date')));
            $endDate   = date("Y-m-d 23:59:59", strtotime($request->input('to_date')));
            $orders->whereBetween("created_at", array($startDate, $endDate));
        }

        $orderStatus = OrderStatus::orderBy('sequence')->get();

        return view('user_orders.list', ['orders' => $orders->get()])
            ->with('orderStatus', $orderStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserOrder $userOrder)
    {
        $order = $userOrder->load(['ordered_items'  => function ($query) {
            $query->with(['product' => function ($query) {
                $query->with('ProductImages');
            }]);
        }, 'user', 'order_status']);
        $orderStatus = OrderStatus::orderBy('sequence')->get();

        return view('user_orders.show')->with([
            'userInfo' => $order->user,
            'orderItems' => $order->ordered_items,
            'orderStatus' => $orderStatus,
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePharmaOrderStatusRequest $request, UserOrder $userOrder)
    {
        $userOrder->order_status_id = $request->input('order_status');
        $userOrder->comment = $request->input('comment');
        $userOrder->save();

        return response(['message' => 'Updated Successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOrder $userOrder)
    {
        return redirect()->route('user_orders.index')->with('status', 'Removed Successfully');
    }

    public function download_invoice(Request $request, $order)
    {
        $order = UserOrder::where('id', $order)->firstOrFail();
        $user = $order->user()->first();

        //return view('public.user.non_pharma_order_invoice', ['user' => $user, 'order' => $order]);
        $pdf = PDF::loadView('public.user.non_pharma_order_invoice', ['userDetail' => $user, 'order' => $order]);

        return $pdf->download('Invoice_' . $order->order_no . '.pdf');

    }

}
