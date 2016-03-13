<?php

namespace App\Repositories;

use App\Models\Map;

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

}