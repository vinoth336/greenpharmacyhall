<?php

namespace App\Http\Controllers;

use App\CategoryType;
use App\Http\Requests\CreateBrandRequest;
use App\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::OrderBy('sequence')->get();

        return view('brands.list', ['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_types = CategoryType::get();
        return view('brands.create')->with('category_types', $category_types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBrandRequest $request)
    {

        DB::beginTransaction();
        try{

            $this->saveBrands(new Brand(), $request);

            DB::commit();

            return redirect()->route('brands.index')->with('status', 'Created Successfully');

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
    public function edit(Brand $brand)
    {
        $category_types = CategoryType::get();
        return view('brands.edit')->with(['brand' => $brand, 'category_types' => $category_types]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateBrandRequest $request, Brand $brand)
    {
        DB::beginTransaction();
        try{

            $this->saveBrands($brand, $request);

            DB::commit();

            return redirect()->route('brands.index')->with('status', 'Created Successfully');

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
    public function destroy(Brand $brand)
    {
        DB::beginTransaction();

        try{
            $brand->unlinkImage($brand->logo);
            $brand->delete();

            DB::commit();

            return redirect()->route('brands.index')->with('status', 'Created Successfully');

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
                $brand = Brand::find($id);
                $brand->sequence = $sequence + 1;
                $brand->save();
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
     * Create or Update the Brand in storage
     *
     * @param ServicesRequest $request
     * @param Brand $Brand
     * @return Brand
     */
    public function saveBrands(Brand $brand, $request)
    {
        $image = $request->has('logo') ? $request->file('logo') : null;
        $brand->storeImage($image, ['width' => 230 , 'height' => 230]);
        $brand->name = $request->input('name');
        $brand->slug = str_slug($request->input('name'));
        $brand->sequence = $brand->sequence ?? Brand::count() + 1;
        $brand->save();
        return $brand;
    }

}
