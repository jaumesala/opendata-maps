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
        $maps = Map::with('user')->orderBy($column, $order)->paginate(setting_value('maps', 'pageResults'));

        return $maps;
    }

    public function getQueryPageOrderedBy($query = '', $column = 'id', $order = 'asc')
    {
        $maps = Map::with('user')->where('name', 'like', '%'.$query.'%')->orderBy($column, $order)->paginate(setting_value('maps', 'pageResults'));

        return $maps;
    }

    public function storeMap($request)
    {
        $map = new Map();

        $map->name = $request->name;
        $map->status = $request->status;
        $map->description = $request->description;
        $map->style = $request->style;
        $map->longitude = $request->longitude;
        $map->latitude = $request->latitude;
        $map->zoom = $request->zoom;
        $map->pitch = $request->pitch;
        $map->bearing = $request->bearing;

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