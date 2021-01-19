<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoriesRequest;
use App\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sub_categories = SubCategory::OrderBy('sequence')->get();

        return view('sub_categories.list', ['sub_categories' => $sub_categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sub_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoriesRequest $request)
    {

        $category_type = new SubCategory();
        $category_type->name = $request->input('name');
        $category_type->slug_name = str_slug($request->input('name'));
        $category_type->sequence = SubCategory::get()->count() + 1;
        $category_type->save();

        return redirect()->route('sub_categories.index')->with('status', 'Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory  $sub_categories
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $sub_categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubCategory  $sub_categories
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        return view('sub_categories.edit')->with(['subCategory' => $subCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $sub_categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $subCategory->name = $request->input('name');
        $subCategory->slug_name = str_slug($request->input('name'));
        $subCategory->save();

        return redirect()->route('sub_categories.index')->with('status', 'Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $sub_categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return redirect()->route('sub_categories.index')->with('status', 'Removed Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $sub_categories
     * @return \Illuminate\Http\Response
     */
    public function updateSequence(Request $request)
    {

        DB::beginTransaction();

        try
        {
            foreach($request->input('sequence') as $sequence => $id) {
                $category_type = SubCategory::find($id);
                $category_type->sequence = $sequence + 1;
                $category_type->save();
            }
        } catch(Exception $e) {
            DB::rollback();
            response('Cannot Update Sequence', 500);
        }

        DB::commit();

        return response(['message' => 'Updated Successfully'], 200);
    }
}
