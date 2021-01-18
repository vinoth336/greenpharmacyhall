<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class Cart extends Model
{
    use HasUuid;

    protected $fillable = ['user_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('current_user', function (Builder $builder) {
            $builder->where('user_id', auth()->user()->id);
        });
    }
}
