<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderRequest;
use App\Slider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::OrderBy('sequence')->get();

        return view('slider.list', ['sliders' => $sliders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {

        DB::beginTransaction();
        try{


            $this->saveSlider(new Slider(), $request);

            DB::commit();

            return redirect()->route('slider.index')->with('status', 'Created Successfully');

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
    public function edit(Slider $slider)
    {
        return view('slider.edit')->with(['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        DB::beginTransaction();
        try{

            $this->saveSlider($slider, $request);

            DB::commit();

            return redirect()->route('slider.index')->with('status', 'Created Successfully');

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
    public function destroy(Slider $slider)
    {
        DB::beginTransaction();

        try{

            $slider->unlinkImage($slider->slider);

            $slider->delete();

            DB::commit();

            return redirect()->route('slider.index')->with('status', 'Created Successfully');

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
                $service = Slider::find($id);
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
     * Create or Update the Slider in storage
     *
     * @param SliderRequest $request
     * @param Slider $slider
     * @return Slider
     */
    public function saveSlider(Slider $service, $request)
    {
        $image = $request->has('slider') ? $request->file('slider') : null;
        $service->storeImage($image);
        $service->description = $request->input('description');
        $service->sequence = $service->sequence ?? Slider::count() + 1;
        $service->font_color = $request->input('font_color');
        $service->save();
        return $service;
    }

}
