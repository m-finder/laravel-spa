<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'alias',
    ];
    public function scopeName($query){
        return is_null(request('name')) ? $query : $query->where('name', request('name'));
    }

    public function scopeAlias($query){
        return is_null(request('alias')) ? $query : $query->where('alias', request('alias')) ;
    }

    public static function isUnique(){
        $role = self::where(function ($query){
            $query->where('name', request('name'))->orWhere('alias', request('alias'));
        })->where('id', '!=', request('id'))->first();
        return is_null($role) ? true : false;
    }
}
