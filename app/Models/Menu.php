<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function scopeName($query){
        return request('name') ? $query->where('name', request('name')) : $query;
    }
}
