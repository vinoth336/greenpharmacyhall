<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;

class PortfolioImage extends Model
{
    use StoreImage;

    protected $fileParamName = 'portfolio_images';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'portfolio_images';

    protected $imageFieldName = 'image';

    protected $table = 'portfolio_images';


}
