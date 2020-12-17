<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{

    use StoreImage;

    protected $fileParamName = 'client_image';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'avatar';

    protected $imageFieldName = 'client_image';


    protected $table = 'testimonials';


}
