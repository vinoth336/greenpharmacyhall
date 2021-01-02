<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminUser extends Authenticatable
{
    protected $guard = 'admin_users';

    protected $redirectTo = '/admin/home';

    protected $table = 'admin_users';

    protected $fillable = ['email', 'name'];
}
