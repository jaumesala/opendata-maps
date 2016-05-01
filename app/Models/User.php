<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Traits\UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function maps()
    {
        return $this->hasMany(Map::class);
    }

    // public function assignRole($role)
    // {
    //     return $this->roles->save(
    //         Role::whereName($role)->firstOrFail()
    //     );
    // }

}
