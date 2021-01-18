<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class UserOrder extends Model
{
    use HasUuid;
    protected $fillable = ['user_id', 'order_no', 'order_status_id'];

    public function ordered_items()
    {
        return $this->hasMany(OrderedItem::class, 'user_order_id', 'id');
    }

    public function getCreatedAtAttribute()
    {
        return date("Y-m-d", strtotime($this->attributes['created_at']));
    }

    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
