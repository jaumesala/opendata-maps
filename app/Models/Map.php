<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Map extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'active', 'visibility', 'style', 'zoom', 'latitude', 'longitude', 'pitch', 'bearing'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function layers()
    {
        return $this->hasMany(Layer::class)->orderBy('order', 'asc');
    }

    /**
     * Scope a query to only include allowed maps.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllowed($query)
    {
        // superadmin user
        if(Auth::check()){
            if(Auth::user()->hasRole('superadmin')){
                // no filter = all maps
                return $query;
            }
        }

        // Other users
        $allowed = $query
            // public maps
            ->where(function($query){
                $query->where('visibility', '=', 'public')->where('active', '=', true);
            });

        if(Auth::check()){
            $allowed = $allowed
                // shared maps
                ->orWhere(function($query){
                    $query->where('visibility', '=', 'shared')->where('active', '=', true);
                })
                // user maps (private)
                ->orWhere(function($query){
                    $query->where('user_id', '=', Auth::user()->id);
                });
        }

        return $allowed;

    }
}
