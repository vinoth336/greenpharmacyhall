<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes, StoreImage;

    protected $fileParamName = 'logo';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'brand_images';

    protected $imageFieldName = 'logo';

    protected $table="brands";

    protected $fillable = ['name', 'status', 'logo', 'sequence'];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active_type_only', function (Builder $builder) {
            $builder->where('status', 1);
            $builder->orderBy('sequence', 'asc');
        });
    }
}
