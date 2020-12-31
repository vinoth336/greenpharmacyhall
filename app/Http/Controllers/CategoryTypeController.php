<?php

namespace App\Http\Controllers;

use App\CategoryType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryTypeController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $category_types = CategoryType::OrderBy('sequence')->get();

        return view('category_types.list', ['category_types' => $category_types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $category_type = new CategoryType();
        $category_type->name = $request->input('name');
        $category_type->sequence = CategoryType::get()->count();
        $category_type->save();

        return redirect()->route('category_types.index')->with('status', 'Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CategoryType  $category_types
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryType $category_types)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CategoryType  $category_types
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryType $category_type)
    {
        return view('category_types.edit')->with(['category_type' => $category_type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CategoryType  $category_types
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryType $category_type)
    {
        $category_type->name = $request->input('name');
        $category_type->save();

        return redirect()->route('category_types.index')->with('status', 'Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CategoryType  $category_types
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryType $category_type)
    {
        $category_type->delete();

        return redirect()->route('category_types.index')->with('status', 'Removed Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CategoryType  $category_types
     * @return \Illuminate\Http\Response
     */
    public function updateSequence(Request $request)
    {

        DB::beginTransaction();

        try
        {
            foreach($request->input('sequence') as $sequence => $id) {
                $category_type = CategoryType::find($id);
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
