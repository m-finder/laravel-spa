<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    public function scopeRouterId($query){
        return request('router_id') ? $query->where('router_id', request('router_id')) : $query;
    }
}
