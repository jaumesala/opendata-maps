<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function maps()
    {
        return $this->belongsToMany(Map::class);
    }
}
