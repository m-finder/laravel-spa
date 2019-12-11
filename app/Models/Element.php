<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $fillable = [
        'router_id', 'name', 'code', 'method', 'path',
    ];

    public function scopeRouterId($query){
        return request('router_id') ? $query->where('router_id', request('router_id')) : $query;
    }

    public static function checkUnique(){
        $element = self::where(function ($query){
            $query->where('name', request('name'))->orWhere('code', request('code'))->orWhere('path', request('path'));
        })->where('id', '!=', request('id'))->first();
        return is_null($element) ? true : false;
    }
}
