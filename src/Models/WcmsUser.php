<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WcmsUser extends Model
{
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }
}
