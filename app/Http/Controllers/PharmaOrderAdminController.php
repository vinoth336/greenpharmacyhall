<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePharmaOrderStatusRequest;
use App\OrderStatus;
use App\PharmaPrescription;
use Illuminate\Http\Request;

class PharmaOrderAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_users')->except('store');
    }

    public function index(Request $request)
    {

        $orders = PharmaPrescription::with(['user', 'order_status'])->OrderBy('created_at');
        if ($request->has('status')) {
            if(!in_array($request->input('status'), ['All', 'all', ''])) {
                $orders->where('status', $request->input('status'));
            }
        }

        if ($request->input('from_date') && $request->input('to_date')) {
            $startDate = date("Y-m-d", strtotime($request->input('from_date')));
            $endDate   = date("Y-m-d", strtotime($request->input('to_date')));
            $orders->whereBetween("created_at", array($startDate, $endDate));
        }

        $orderStatus = OrderStatus::orderBy('sequence')->get();

        return view('pharma_orders.list', ['orders' => $orders->get()])
        ->with('orderStatus', $orderStatus)
        ;
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
    public function show(PharmaPrescription $pharma_order)
    {
        $pharma_order = $pharma_order->load(['user', 'order_status']);
        return $pharma_order;
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
    public function update(UpdatePharmaOrderStatusRequest $request, PharmaPrescription $pharma_order)
    {
        $pharma_order->order_status_id = $request->input('order_status');
        $pharma_order->save();

        return response(['message' => 'Updated Successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PharmaPrescription $pharma_order)
    {
        return redirect()->route('pharma_orders.index')->with('status', 'Removed Successfully');
    }

}
