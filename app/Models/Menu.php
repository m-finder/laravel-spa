<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'id', 'parent_id', 'name', 'title', 'path', 'icon', 'component', 'redirect', 'order_num', 'hidden'
    ];

    public function elements(){
        return $this->hasMany(Element::class, 'menu_id', 'id');
    }
}
