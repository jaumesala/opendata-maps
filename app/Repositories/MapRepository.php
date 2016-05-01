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
        //get allowed maps
        $maps = Map::allowed()->with('user', 'tags', 'layers.source')->get();

        // find out if id is allowed
        $map = $maps->first(function ($key, $model) use ($id) {
            return $model->id == $id;
        });

        return $map;
    }

    public function getByHash($hash)
    {
        //get allowed maps
        $maps = Map::allowed()->with('user', 'tags', 'layers.source')->get();

        // find out if hash is allowed
        $map = $maps->first(function ($key, $model) use ($hash) {
            return $model->hash == $hash;
        });

        return $map;
    }


    public function getAllOrderedBy($column = 'id', $order = 'asc')
    {
        $maps = Map::allowed()->with('user')->orderBy($column, $order)->get();

        return $maps;
    }

    public function getPageOrderedBy($column = 'id', $order = 'asc')
    {
        $maps = Map::allowed()->with('user')->orderBy($column, $order)->paginate(setting_value('maps', 'pageResults'));

        return $maps;
    }

    public function getQueryPageOrderedBy($query = '', $column = 'id', $order = 'asc')
    {
        $maps = Map::allowed()->with('user')->where('name', 'like', '%'.$query.'%')->orderBy($column, $order)->paginate(setting_value('maps', 'pageResults'));

        return $maps;
    }

    public function storeMap($request)
    {
        $map = new Map();

        //create public hash
        $hash = "";
        do
        {
            $hash = str_random(4);
        }
        while (Map::where("hash", "=", $hash)->first() instanceof Map);
        $map->hash = $hash;

        $values = $request->except('_token', '_method', '_section', 'tags');
        $map->fill($values);

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

    public function updateMap($request)
    {
        $id = $request->route('map');
        $map = Map::findOrFail($id);

        $values = $request->except('_token', '_method', '_section', 'tags');
        $map->fill($values);

        if( $request->has('tags') && is_array($request->tags) )
        {
            $tagList = Tag::lists('id')->toArray();

            $cleanTags = array_intersect($request->tags, $tagList);

            $map->tags()->sync($cleanTags);
        }

        return $map->save();
    }

    public function disableMap($id)
    {
        $map = Map::find($id);

        $map->fill(['active' => false]);

        return $map->save();
    }

    public function enableMap($id)
    {
        $map = Map::find($id);

        $map->fill(['active' => true]);

        return $map->save();
    }

    public function destroyMap($id)
    {
        $map = Map::findOrFail($id);

        $result = Map::destroy($id);

        return $result;
    }

    public function countView($map){
        $map->views = $map->views +1;
        $map->save();
    }

}