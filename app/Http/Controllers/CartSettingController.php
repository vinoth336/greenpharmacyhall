<?php

namespace App\Http\Controllers;

use App\CartSettings;
use Illuminate\Http\Request;

class CartSettingController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CartSettings = CartSettings::first();

        return view('cart_settings.create')->with(['CartSettings' => $CartSettings]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $CartSettings = CartSettings::first();
        $CartSettings->min_home_delivery_order_amount = $request->input('min_home_delivery_order_amount');
        $CartSettings->min_shop_pickup_order_amount = $request->input('min_shop_pickup_order_amount');
        $CartSettings->save();
        setCartSettings(
            [
                'free_deliver_min_amt' => $request->input('min_home_delivery_order_amount'),
                'shop_pickup_min_amt' => $request->input('min_shop_pickup_order_amount')
            ]
        );

        return redirect()->route('cart_settings.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CartSettings  $CartSettings
     * @return \Illuminate\Http\Response
     */
    public function show(CartSettings $CartSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CartSettings  $CartSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(CartSettings $CartSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CartSettings  $CartSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartSettings $CartSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CartSettings  $CartSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartSettings $CartSettings)
    {
        //
    }
}
