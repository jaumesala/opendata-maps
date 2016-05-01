<?php

namespace App\Repositories;

use App\Models\User;
use Auth;

class UserRepository
{
    public function getAll()
    {
        $users = User::all();

        return $users;
    }


    public function getById($id)
    {
        $user = User::findOrFail($id);

        return $user;
    }


    public function getAllOrderedBy($column = 'id', $order = 'asc')
    {
        $users = User::with('roles')->orderBy($column, $order)->get();

        return $users;
    }


    public function storeUser($request)
    {
        $user = User::firstOrNew([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $result = $user->save();

        $roles = array_flatten($request->roles);

        $user->roles()->attach($roles);

        return $result;
    }

    public function updateUser($request)
    {

        $id = $request->route('user');

        $model = User::findOrFail($id);

        $model->fill([
            'name' => $request->name,
            'email' => $request->email,
            ]);

        if($request->has('password')){
            $model->password = bcrypt($request->password);
        }

        $roles = array_flatten($request->roles);

        $model->roles()->sync($roles);

        return $model->save();

    }


    public function destroyUser($id)
    {
        $authUser = Auth::user();
        $user = User::findOrFail($id);

        if($user->id == $authUser->id)
        {
            return -1;
        }

        $result = User::destroy($id);

        return $result;
    }

}