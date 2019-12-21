<?php

namespace App\Models;

class Role extends Model
{
    public function scopeName($query){
        return !is_null(request('name')) ? $query->where('name', request('name')) : $query;
    }

    public function scopeAlias($query){
        return !is_null(request('alias')) ? $query->where('alias', request('alias')) : $query;
    }

    public static function checkUnique(){
        $role = self::where(function ($query){
            $query->where('name', request('name'))->orWhere('alias', request('alias'));
        })->where('id', '!=', request('id'))->first();
        return is_null($role) ? true : false;
    }
}
