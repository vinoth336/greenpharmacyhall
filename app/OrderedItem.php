<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class OrderedItem extends Model
{
    use HasUuid;

    protected $fillable = ['user_order_id', 'user_id', 'product_id', 'qty', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
