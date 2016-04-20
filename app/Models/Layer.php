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
        'name', 'map_id', 'source_id', 'visible', 'opacity', 'type', 'minzoom', 'maxzoom', 'interactive', 'color', 'outline-color', 'width', 'gap-width', 'dasharray', 'radius', 'blur', 'choropleth-source', 'clusters', 'schema-color', 'schema-reverse', 'cluster-maxzoom', 'cluster-radius'
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
