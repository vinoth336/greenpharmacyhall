<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Services;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Services::OrderBy('sequence')->get();

        return view('services.list', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequest $request)
    {

        DB::beginTransaction();
        try{

            $this->saveServices(new Services(), $request);

            DB::commit();

            return redirect()->route('services.index')->with('status', 'Created Successfully');

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
    public function edit(Services $service)
    {
        return view('services.edit')->with(['service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateServiceRequest $request, Services $service)
    {
        DB::beginTransaction();
        try{

            $this->saveServices($service, $request);

            DB::commit();

            return redirect()->route('services.index')->with('status', 'Created Successfully');

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
    public function destroy(Services $service)
    {
        DB::beginTransaction();

        try{

            $service->unlinkImage($service->banner);

            $service->portfolios()->detach();
            $service->delete();

            DB::commit();

            return redirect()->route('services.index')->with('status', 'Created Successfully');

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
                $service = Services::find($id);
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
     * Create or Update the Services in storage
     *
     * @param ServicesRequest $request
     * @param Services $Services
     * @return Services
     */
    public function saveServices(Services $service, $request)
    {
        $image = $request->has('banner') ? $request->file('banner') : null;
        $service->storeImage($image, ['width' => 230 , 'height' => 230]);
        $service->name = $request->input('name');
        $service->slug = str_slug($request->input('name'));
        $service->icon = $request->input('icon');
        $service->description = $request->input('description');
        $service->sequence = $service->sequence ?? Services::count() + 1;
        $service->save();
        return $service;
    }

}
