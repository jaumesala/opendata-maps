<?php

namespace App\Repositories;

use App\Models\Layer;
use App\Models\Map;
use App\Models\Source;

class LayerRepository
{
    public function getAll()
    {
        $layers = Layer::all();

        return $layers;
    }


    public function getById($id)
    {
        $layer = Layer::with('source', 'map')->findOrFail($id);

        return $layer;
    }

    public function storeLayer($request)
    {
        $layer = new Layer();

        $layer->name = $request->name;
        $layer->visible = $request->visible;
        $layer->opacity = $request->opacity;

        $map = Map::findOrFail($request->map_id);
        $layer->map()->associate($map);

        $source = Source::findOrFail($request->source_id);
        $layer->source()->associate($source);

        $layer->save();

        return $layer;
    }

    public function updateLayer($request)
    {
        // $id = $request->route('map');
        // $layer = Layer::findOrFail($id);

        // $values = $request->except('_token', '_method', '_section', 'tags');
        // $layer->fill($values);

        // if( $request->has('tags') && is_array($request->tags) )
        // {
        //     $tagList = Tag::lists('id')->toArray();

        //     $cleanTags = array_intersect($request->tags, $tagList);

        //     $layer->tags()->sync($cleanTags);
        // }

        // return $layer->save();
    }

    public function destroyLayer($id)
    {
        // $layer = Layer::findOrFail($id);

        // $result = Layer::destroy($id);

        // return $result;
    }
}