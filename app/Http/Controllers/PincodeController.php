<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pincode;
use App\Imports\ImportPincode;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PincodeController extends Controller
{
    public function index()
    {
        $pincodeList = Pincode::with('delivery_estimations')->get();

        return view('pincode.list',["pincodes"=>$pincodeList]);
    }
    public function import_pincode()
    {
            return view('pincode.import');
    }
    public function import(){
        ini_set('max_execution_time', 180);
        DB::beginTransaction();

        try {
            Excel::import(new ImportPincode, request()->file('pincode_list'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            die($e->getMessage());
            response(['status' => 'Cannot Import File'], 500);
        }    }
    public function getEstimate(Request $request){
        $message='Delivery items within ';
        $status=200;
        $pincode = Pincode::where('pincode', $request->get('pincode'))->first();
        if ($pincode) {
            $estimationDelivery = $pincode->delivery_estimations;
            if($estimationDelivery){
            if($estimationDelivery['min']==$estimationDelivery['max']){
                $message.=$estimationDelivery['min'].' day';
            } else {
                $message.=$estimationDelivery['min'].' to '.$estimationDelivery['max'].' days';
            }
        } else {
            $status=404;
            $message='Sorry! no delivery for this pincode ';
        }
} else {
    // Pincode not found
    $status=404;
    $message='Sorry! no delivery for this pincode ';
}
return response(['message' => $message,'status'=>$status], $status);
        }
}
