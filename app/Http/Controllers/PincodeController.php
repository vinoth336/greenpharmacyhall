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
        $pincodeList = Pincode::with('DeliveryEstimations')->get();
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
}
