<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use Traits\RoleTrait;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    // public function givePermissionTo(Permission $permission)
    // {
    //     return $this->permissions()->save($permission);
    // }
}
