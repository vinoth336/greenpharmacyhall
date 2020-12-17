<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    use StoreImage;

    protected $fileParamName = 'slider';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'slider';

    protected $imageFieldName = 'slider';

    protected $table = 'sliders';

    public $timestamp = true;


}
