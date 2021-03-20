<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class PrescriptionDetail extends Model
{
    use StoreImage, HasUuid;

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


}
