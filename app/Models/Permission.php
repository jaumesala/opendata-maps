<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    use Traits\PermissionTrait;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
