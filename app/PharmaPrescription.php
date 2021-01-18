<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jamesh\Uuid\HasUuid;

class PharmaPrescription extends Model
{
    use StoreImage, SoftDeletes, HasUuid;

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

    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
