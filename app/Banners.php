<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use StoreImage;

    protected $fileParamName = 'banner';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'banners';

    protected $imageFieldName = 'banner';

    protected $table = 'banners';

    public $timestamp = true;
}
