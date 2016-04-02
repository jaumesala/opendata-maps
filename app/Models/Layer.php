<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layer extends Model
{
    public function map()
    {
        return $this->belongsTo(Map::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
