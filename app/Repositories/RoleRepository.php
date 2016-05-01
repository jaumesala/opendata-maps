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

    public function getById($id)
    {
        $role = Role::findOrFail($id);

        return $role;
    }

    public function getAllOrderedBy($column = 'id', $order = 'asc')
    {
        $roles = Role::orderBy($column, $order)->get();

        return $roles;
    }

    public function storeRole($request)
    {
        $role = Role::firstOrNew([
            'name' => $request->name,
            'label' => $request->label
        ]);

        $result = $role->save();

        $permissions = array_flatten($request->permissions);

        $role->permissions()->attach($permissions);

        return $result;
    }

    public function updateRole($request)
    {

        $id = $request->route('role');

        $model = Role::findOrFail($id);

        $model->fill([
            'name' => $request->name,
            'label' => $request->label,
            ]);

        $permissions = array_flatten($request->permissions);

        $model->permissions()->sync($permissions);

        return $model->save();

    }


    public function destroyRole($id)
    {
        $result = Role::destroy($id);

        return $result;
    }

}