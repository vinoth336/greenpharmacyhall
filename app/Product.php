<?php

namespace App;

use App\Traits\RelatedProducts;
use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class Product extends Model
{
    use StoreImage, HasUuid, RelatedProducts;

    protected $fileParamName = 'portfolio_banner_image';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'products';

    protected $imageFieldName = 'background_image';

    protected $table = 'products';

    protected $fillable = ['name', 'description', 'sequence', 'background_image'];


    public function ProductImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id' );
    }

    public function services()
    {
        return $this->belongsToMany(Services::class)->withTimestamps();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }


    public static function boot()
    {
        parent::boot();

        static::saved(function($model){
            setSiteMenuValueInCache(getSiteMenus());
        });

        static::updated(function($model){
            setSiteMenuValueInCache(getSiteMenus());
        });

        static::deleted(function($model){
            setSiteMenuValueInCache(getSiteMenus());
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getActualPriceAttribute()
    {

        return $this->discount_amount > 0 ? $this->discount_amount : $this->price;
    }

    public function getProductUrlAttribute()
    {
        return env('APP_URL') . "product/" . $this->slug;
    }

}
