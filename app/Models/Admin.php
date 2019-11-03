<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    public function scopeName($query, $name)
    {
        return !is_null($name) ? $query->where('name', $name) : $query;
    }

    public function scopeEmail($query, $email)
    {
        return !is_null($email) ? $query->where('email', $email) : $query;
    }
}
