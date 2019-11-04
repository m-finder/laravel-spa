<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function scopeName($query, $name){
        return !is_null($name) ? $query->where('name', $name) : $query;
    }

    public function scopeAlias($query, $alias){
        return !is_null($alias) ? $query->where('alias', $alias) : $query;
    }
}
