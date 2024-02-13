<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $fillable=['pincode','city_id','state_id'];
    protected $table='pincodes';

    public function DeliveryEstimations(){
        return $this->hasMany(DeliveryEstimation::class, 'pincode_id', 'id' );
    }
}
