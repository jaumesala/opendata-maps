<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'origin_type',
        'origin_url',
        'origin_format',
        'origin_size',
        'name',
        'description',
        'web',
        'sync_status',
        'sync_interval',
        'synced_at'
    ];
}
