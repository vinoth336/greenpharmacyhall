<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail as AuthMustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jamesh\Uuid\HasUuid;

class User extends Authenticatable
{
    use Notifiable, AuthMustVerifyEmail, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'sex', 'city_id', 'state_id', 'zipcode', 'phone_no',
        'address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $incrementing = false;
    protected $primaryKey = 'phone_no';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pharma_orders()
    {
        return $this->hasMany(PharmaPrescription::class, 'user_id', 'id');
    }

    public function non_pharma_orders()
    {
        return $this->hasMany(UserOrder::class, 'user_id', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    public function change_password()
    {
        return $this->hasOne(CustomerChangePasswordRequest::class, 'user_id', 'id');
    }

    public function isActiveUser()
    {
        return $this->is_active ? true : false;
    }

}
