<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jamesh\Uuid\HasUuid;

class Enquiries extends Model
{
    use SoftDeletes, HasUuid;

    protected $table = 'enquiries';

    protected $fillable = ['name', 'service_id', 'phone_no', 'email', 'subject', 'message', 'status'];


    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i', strtotime($value));
    }

}
