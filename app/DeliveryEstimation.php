<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryEstimation extends Model
{
    protected $table='delivery_estimations';

     /**
     * Get the pincode that owns the estimation delivery.
     */
    public function pincode()
    {
        return $this->belongsTo(Pincode::class);
    }
}
