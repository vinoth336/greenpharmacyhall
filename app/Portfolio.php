<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use StoreImage;

    protected $fileParamName = 'portfolio_banner_image';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'portfolios';

    protected $imageFieldName = 'background_image';

    protected $table = 'portfolios';

    protected $fillable = ['name', 'description', 'sequence', 'background_image'];


    public function portfolioImages()
    {
        return $this->hasMany(PortfolioImage::class, 'portfolio_id', 'id' );
    }

    public function services()
    {
        return $this->belongsToMany(Services::class)->withTimestamps();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }


}
