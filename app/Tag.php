<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Jamesh\Uuid\HasUuid;

class Tag extends Model
{

    use SoftDeletes, HasUuid;

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'name', 'slug_name'];

    protected $casts = ['name' => 'string'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
           if($model->slug_name == null) {
               $model->slug_name = str_slug($model->name);
           }
           if($model->id == null) {
            $model->id = (string) Str::uuid();
        }
        });
    }
}
