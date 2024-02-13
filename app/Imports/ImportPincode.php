<?php

namespace App\Imports;
use App\Pincode;
use App\DeliveryEstimation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPincode implements ToModel,WithHeadingRow 
{
    public function model(array $row)
    {
        $deliveryEstimation=DeliveryEstimation::firstOrCreate(
            []
        );
        $deliveryEstimation->pincode_id=$this->getPincodeId($row);
        $deliveryEstimation->min=$row['min'];
        $deliveryEstimation->max=$row['max'];
        
        $deliveryEstimation->save();
        return $deliveryEstimation;
    }
    public function getPincodeId($row){
        if($row['pincode'] != '') {
            $pincodeRows = Pincode::firstOrCreate(
                [
                   'pincode'=>$row['pincode'],
                   'city_id'=>'1',
                   'state_id'=>'1'
                ]
            );
            return $pincodeRows->id ?? null;
        }

        return null;
    }
}
?>