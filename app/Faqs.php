<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jamesh\Uuid\HasUuid;

class Faqs extends Model
{

    use SoftDeletes, HasUuid;


    protected $table = 'faqs';

    protected $fillable = ['question', 'answer', 'sequence'];

    public $timestamps = true;

    public static function boot()
    {

        parent::boot();
        static::creating(function($model)
        {

        });
    }

}
