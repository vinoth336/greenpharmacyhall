<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmaPrescription extends Model
{
    use StoreImage, SoftDeletes;

    protected $fileParamName = 'prescription';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'prescriptions';

    protected $imageFieldName = 'image';

    public $resize = false;


    public function getCreatedAtAttribute($value)
    {
        return date("d-m-Y", strtotime($value));
    }

    public function getImageUrlAttribute()
    {
        if($this->attributes['image']) {
            return secure_url(asset('web/images/prescriptions/' . $this->attributes['image']));
        }

        return null;
    }

    public function getOrderStatusTextAttribute()
    {
        $value = $this->attributes['order_status'];
        if($value == 1) {
            return 'Pending';
        }else if($value == 2) {
            return 'Approved';
        }else if($value == 3) {
            return 'Processing';
        }else if($value == 4) {
            return 'Pending';
        }else if($value == 5) {
            return 'Out For Delivery';
        }else if($value == 6) {
            return 'Deliveried';
        }else if($value == 7) {
            return 'Not Deliveried';
        }else if($value == 8) {
            return 'Order Cancelled By You';
        }else if($value == 9) {
            return 'Order Cancelled By Admin';
        }
    }
}
