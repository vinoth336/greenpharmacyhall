<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class Testimonial extends Model
{

    use StoreImage, HasUuid;

    protected $fileParamName = 'client_image';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'avatar';

    protected $imageFieldName = 'client_image';


    protected $table = 'testimonials';


}
