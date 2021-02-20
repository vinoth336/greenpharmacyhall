<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class SubCategory extends Model
{
    use HasUuid;

    protected $fillable = ['slug_name', 'name', 'sequence'];
}
