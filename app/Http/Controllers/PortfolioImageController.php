<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Product;
use App\ProductImage;
use App\Services;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PortfolioImageController extends Controller
{


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImage $productImage)
    {
        DB::beginTransaction();

        try{
            $productImage->unlinkImage($productImage->image);
            $productImage->delete();

            DB::commit();

            return response(['status' => 'removed Successfully']);

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
                $service = ProductImage::find($id);
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


}
