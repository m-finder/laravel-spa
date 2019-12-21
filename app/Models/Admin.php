<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Admin extends Authenticatable
{
    protected $guard_name = 'admin-api';

    protected $fillable = [
        'role_id','name', 'email', 'password', 'avatar', 'api_token',
    ];

    protected $hidden = [
        'password', 'api_token',
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

    public function checkAuth($path){
        $role_id = Auth::user()->role->id;
        $element = Element::where('path', $path)->first();
        $has = RoleElement::where('element_id', $element->id)->where('role_id', $role_id)->count();
        return $has;
    }
}
