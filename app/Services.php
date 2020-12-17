<?php

namespace App;

use App\Traits\StoreImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use SoftDeletes, StoreImage;

    protected $fileParamName = 'banner';

    protected $storeFileName = '';

    protected $storeFileNameAsUploadName = '';

    protected $storagePath = 'portfolio_images';

    protected $imageFieldName = 'banner';

    protected $table="services";

    protected $fillable = ['name', 'description', 'icon', 'banner', 'sequence'];

    public $timestamps = true;


    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }

}
