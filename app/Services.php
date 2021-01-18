<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jamesh\Uuid\HasUuid;

class Services extends Model
{
    use SoftDeletes, StoreImage, HasUuid;

    protected $fileParamName = 'banner';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'product_images';

    protected $imageFieldName = 'banner';

    protected $table="services";

    protected $fillable = ['name', 'description', 'icon', 'banner', 'sequence'];

    public $timestamps = true;


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function category_type()
    {
        return $this->belongsTo(CategoryType::class, 'category_type_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

    }
}
