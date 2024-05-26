<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserOrder extends Model implements HasMedia
{
    use InteractsWithMedia;
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

    public function order_payment_status()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_no');
    }
    public function getDeliveryTypeAttribute()
    {
        return DELIVERY_TYPE[$this->attributes['delivery_type']] ?? null;
    }

    public function scopeAuthUser($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
}
