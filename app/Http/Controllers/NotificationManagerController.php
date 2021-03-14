<?php

namespace App\Http\Controllers;

use App\NotificationManager;
use Illuminate\Http\Request;

class NotificationManagerController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $NotificationManager = NotificationManager::first();

        return view('notification_manager.create')->with(['NotificationManager' => $NotificationManager]);
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

        $NotificationManager = NotificationManager::first();
        $NotificationManager->order_create = $request->input('order_create');
        $NotificationManager->order_cancel = $request->input('order_cancel');
        $NotificationManager->save();
        setMailNotificationDetailsInCache();

        return redirect()->route('notification_manager.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NotificationManager  $NotificationManager
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationManager $NotificationManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NotificationManager  $NotificationManager
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationManager $NotificationManager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NotificationManager  $NotificationManager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificationManager $NotificationManager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NotificationManager  $NotificationManager
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationManager $NotificationManager)
    {
        //
    }
}
