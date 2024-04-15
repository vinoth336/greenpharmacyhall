<?php

namespace App;

use App\Traits\RelatedProducts;
use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Builder;
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

    protected $guarded = '';

    protected $fillable = ['name', 'description', 'sequence', 'background_image', 'slug'];

    protected $resizeImage = ['width' => '800', 'height' => '800'];

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

    public function product_tags()
    {
        return $this->belongsToMany(Tag::class,'product_tag', 'product_id', 'tag_id')->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function($model){
            if($model->brand_id) {
                setSiteMenuValueInCache(getSiteMenus());
            }
        });

        static::updated(function($model){
            if($model->brand_id) {
                setSiteMenuValueInCache(getSiteMenus());
            }
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

    public static function scopeActiveProject($query)
    {
        return $query->where('products.status', 1);
    }

    public function getReasonForNotSale()
    {
        if($this->isPharmaProduct()) {
            return "Is Scheduled Product and its not for sale. Contact Us for more information.";
        } else {
            return "Currently the item is not available for the sale. Kindly check later";
        }
    }

    public function isForSale()
    {
        if ($this->isPharmaProduct()) {

            return $this->isPharmaProductForSale();
        } else {

            return $this->is_for_sales;
        }
    }

    public function isPharmaProduct()
    {
        return $this->is_pharma_product;
    }

    public function isPharmaProductForSale()
    {
        if (!$this->is_scheduled_drug && $this->is_for_sales) {
            return true;
        }

        return false;
    }
}
