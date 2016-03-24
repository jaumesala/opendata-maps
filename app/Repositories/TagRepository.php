<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    public function getAll()
    {
        $tags = Tag::all();

        return $tags;
    }


    public function getById($id)
    {
        $tag = Tag::findOrFail($id);

        return $tag;
    }


    public function getAllOrderedBy($column = 'id', $order = 'asc')
    {
        $tags = Tag::orderBy($column, $order)->get();

        return $tags;
    }

    public function storeTag($request)
    {
        // $tag = new Map([
        //     'name' => $request->name,
        //     'status' => $request->status,
        //     'description' => $request->description,
        // ]);

        // $tag->user()->associate(Auth::user());

        // dd($tag);

        // $result = $user->save();

        // $roles = array_flatten($request->roles);

        // $user->roles()->attach($roles);

        // return $result;
    }

}