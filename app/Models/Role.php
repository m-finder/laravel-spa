<?php

namespace App\Models;

class Role extends Model
{
    public function scopeName($query, $name){
        return !is_null($name) ? $query->where('name', $name) : $query;
    }

    public function scopeAlias($query, $alias){
        return !is_null($alias) ? $query->where('alias', $alias) : $query;
    }

    public static function checkUnique(){
        $role = self::where(function ($query){
            $query->where('name', request('name'))->orWhere('alias', request('alias'));
        })->where('id', '!=', request('id'))->first();
        return is_null($role) ? true : false;
    }
}
