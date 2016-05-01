<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
