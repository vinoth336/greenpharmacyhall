<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Jamesh\Uuid\HasUuid;

class AdminUser extends Authenticatable
{
    use HasUuid;

    protected $primaryKey = 'email';

    protected $guard = 'admin_users';

    protected $redirectTo = '/admin/home';

    protected $table = 'admin_users';

    protected $fillable = ['email', 'name'];
}
