<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    protected $guarded = ['id'];

    public function scopeFilter($query, $filters = []) {

        foreach ($filters as $key => $value) {
            if (!is_null($value)) {
                $query->where($key, $value);
            }
        }
    }
}
