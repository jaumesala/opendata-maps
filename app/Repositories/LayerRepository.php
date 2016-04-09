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

        $layer->type = $request->type;
        $layer->interactive = $request->interactive;
        $layer->minzoom = $request->minzoom;
        $layer->maxzoom = $request->maxzoom;

        $map = Map::findOrFail($request->map_id);
        $layer->map()->associate($map);

        $source = Source::findOrFail($request->source_id);
        $layer->source()->associate($source);

        $layer->save();

        return $layer;
    }

    public function updateLayer($request)
    {
        $id = $request->route('layer');
        $layer = Layer::findOrFail($id);

        $values = $request->except('_token', '_method');
        $layer->fill($values);

        return $layer->save();
    }

    public function destroyLayer($id)
    {
        $layer = Layer::findOrFail($id);

        $result = Layer::destroy($id);

        return $result;
    }

    public function sortLayers($request)
    {
        $layers = $request->input('layer');

        foreach($layers as $order => $id) {
            $layer = Layer::findOrFail($id);
            $layer->order = $order;
            $layer->save();
        }

        return true;
    }
}