<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class Slider extends Model
{

    use StoreImage, HasUuid;

    protected $fileParamName = 'slider';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'slider';

    protected $imageFieldName = 'slider';

    protected $table = 'sliders';

    public $timestamp = true;

    protected $resizeImage = true;

    protected $resizeValue = ['width' => 1440, 'height' => 650];

}
