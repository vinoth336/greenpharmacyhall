<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class ProductImage extends Model
{
    use StoreImage, HasUuid;

    protected $fileParamName = 'product_images';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'product_images';

    protected $imageFieldName = 'image';

    protected $table = 'product_images';

    public function getProductImageAttribute()
    {
        return asset('web/images/product_images/thumbnails/') . "/" . $this->image;
    }

}
