<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jamesh\Uuid\HasUuid;

class CustomerChangePasswordRequest extends Model
{

    use HasUuid, SoftDeletes;

    public $request_status = [
        'pending' => 'Pending',
        'contact' => 'Contact',
        'reset_password' => 'Reset Password',
        'password_changed' => 'Password Changed',
        'cancel' => 'Cancel',
        'fake' => 'Fake'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d H:i', strtotime($value));
    }

    public function getRequestStatusAttribute()
    {
        return $this->request_status[$this->status] ?? null;
    }

}
