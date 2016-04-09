<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'map_id', 'source_id', 'visible', 'opacity', 'type', 'minzoom', 'maxzoom', 'interactive', 'color', 'outline-color', 'width', 'gap-width', 'dasharray', 'radius', 'blur'
    ];

    public function map()
    {
        return $this->belongsTo(Map::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
