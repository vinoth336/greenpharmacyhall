<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class Banners extends Model
{
    use StoreImage, HasUuid;

    protected $fileParamName = 'banner';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'banners';

    protected $imageFieldName = 'banner';

    protected $table = 'banners';

    public $timestamp = true;
}
