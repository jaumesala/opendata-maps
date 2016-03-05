<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
    public function getAll()
    {
        $roles = Role::all();

        return $roles;
    }

    public function getAllOrderedBy($column = 'id', $order = 'asc')
    {
        $roles = Role::orderBy($column, $order)->get();

        return $roles;
    }

}