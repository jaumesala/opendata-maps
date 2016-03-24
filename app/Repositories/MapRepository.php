<?php

namespace App\Repositories;

use App\Models\Map;
use App\Models\Tag;
use Auth;

class MapRepository
{
    public function getAll()
    {
        $maps = Map::all();

        return $maps;
    }


    public function getById($id)
    {
        $map = Map::with('user')->findOrFail($id);

        return $map;
    }


    public function getAllOrderedBy($column = 'id', $order = 'asc')
    {
        $maps = Map::with('user')->orderBy($column, $order)->get();

        return $maps;
    }

    public function getPageOrderedBy($column = 'id', $order = 'asc')
    {
        $maps = Map::with('user')->orderBy($column, $order)->paginate(12);

        return $maps;
    }

    public function getQueryPageOrderedBy($query = '', $column = 'id', $order = 'asc')
    {
        $maps = Map::with('user')->where('name', 'like', '%'.$query.'%')->orderBy($column, $order)->paginate(12);

        return $maps;
    }

    public function storeMap($request)
    {
        $map = new Map([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        $map->user()->associate(Auth::user());

        $map->save();

        if( $request->has('tags') && is_array($request->tags) )
        {
            $tagList = Tag::lists('id')->toArray();

            $cleanTags = array_intersect($request->tags, $tagList);

            $map->tags()->sync($cleanTags);
        }

        return $map;
    }

}