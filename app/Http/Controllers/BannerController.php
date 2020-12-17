<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Banners;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Banners = Banners::OrderBy('sequence')->get();

        return view('banner.list', ['banners' => $Banners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {

        DB::beginTransaction();
        try{


            $this->saveBanner(new Banners(), $request);

            DB::commit();

            return redirect()->route('banner.index')->with('status', 'Created Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Store Data"], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banners $banner)
    {
        return view('banner.edit')->with(['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, Banners $banner)
    {
        DB::beginTransaction();
        try{

            $this->saveBanner($banner, $request);

            DB::commit();

            return redirect()->route('banner.index')->with('status', 'Created Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Store Data"], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banners $banner)
    {
        DB::beginTransaction();

        try{

            $banner->unlinkImage($banner->Banner);

            $banner->delete();

            DB::commit();

            return redirect()->route('banner.index')->with('status', 'Created Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Delete Data"], 500);
        }

    }

    public function updateSequence(Request $request)
    {

        DB::beginTransaction();

        try
        {
            foreach($request->input('sequence') as $sequence => $id) {
                $service = Banners::find($id);
                $service->sequence = $sequence + 1;
                $service->save();
            }
        } catch(Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            response(['status' => 'Cannot Update Sequence'], 500);
        }

        DB::commit();

        return response(['message' => 'Updated Successfully'], 200);
    }


     /**
     * Create or Update the Banner in storage
     *
     * @param BannerRequest $request
     * @param Banners $banner
     * @return Banner
     */
    public function saveBanner(Banners $service, $request)
    {
        $image = $request->has('banner') ? $request->file('banner') : null;
        $service->storeImage($image);
        $service->sequence = $service->sequence ?? Banners::count() + 1;
        $service->banner_size = $request->input('banner_size');
        $service->save();
        return $service;
    }

}
