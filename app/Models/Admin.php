<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    protected $fillable = [
        'role_id','name', 'email', 'password', 'avatar', 'api_token',
    ];

    public function scopeName($query, $name)
    {
        return !is_null($name) ? $query->where('name', $name) : $query;
    }

    public function scopeEmail($query, $email)
    {
        return !is_null($email) ? $query->where('email', $email) : $query;
    }

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
    public static function checkUnique(){
        $admin = self::where(function ($query){
            $query->where('name', request('name'))->orWhere('email', request('email'));
        })->where('id', '!=', request('id'))->first();
        return is_null($admin) ? true : false;
    }
}
