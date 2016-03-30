<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository
{
    public function getAll()
    {
        $permissions = Permission::all();

        return $permissions;
    }

    public function getById($id)
    {
        $permissions = Permission::findOrFail($id);

        return $permissions;
    }

    public function getAllOrderedBy($column = 'id', $order = 'asc')
    {
        $permissionss = Permission::orderBy($column, $order)->get();

        return $permissionss;
    }

    public function storePermission($request)
    {
        $permissions = Permission::firstOrNew([
            'name' => $request->name,
            'label' => $request->label
        ]);

        $result = $permissions->save();

        return $result;
    }

    public function updatePermission($request)
    {

        $id = $request->route('permission');

        $model = Permission::findOrFail($id);

        $model->fill([
            'name' => $request->name,
            'label' => $request->label,
            ]);

        return $model->save();

    }


    public function destroyPermission($id)
    {
        $result = Permission::destroy($id);

        return $result;
    }

}