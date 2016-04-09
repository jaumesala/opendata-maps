<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\LayerRepository;
use App\Repositories\MapRepository;
use App\Http\Requests\Admin\CreateLayerRequest;
use App\Http\Requests\Admin\DestroyLayerRequest;
use App\Http\Requests\Admin\UpdateLayerRequest;
use App\Http\Requests\Admin\SortLayersRequest;
use Storage;

class LayersController extends Controller
{
    /**
     * The Layer repository instance.
     *
     * @var LayerRepository
     */
    protected $layer;

    /**
     * The Map repository instance.
     *
     * @var LayerRepository
     */
    protected $map;

    /**
     * Create a new controller instance.
     *
     * @param  LayerRepository  $layer
     * @return void
     */
    public function __construct(LayerRepository $layer, MapRepository $map)
    {
        $this->layer = $layer;
        $this->map = $map;

        // $this->middleware('permission:list-layers', ['only' => [ 'index' ]]);
        // $this->middleware('permission:create-layer', ['only' => [ 'create', 'store' ]]);
        // $this->middleware('permission:show-layer', ['only' => [ 'show' ]]);
        // $this->middleware('permission:edit-layer', ['only' => [ 'edit', 'update' ]]);
        // $this->middleware('permission:destroy-layer', ['only' => [ 'destroy' ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TagRepository $tag)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLayerRequest $request)
    {
        // dd($request->map_id);
        $layer = $this->layer->storeLayer($request);

        if(!$layer){
            return redirect()->back()->with('status', 'create-error');
        }

        return redirect()->route('admin.map.edit', $layer->map_id)->with('status', 'create-success')->with('activeLayer', $layer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLayerRequest $request, $id)
    {
        $layer = $this->layer->getById($id);
        $result = $this->layer->updateLayer($request);

        if(!$result){
            return redirect()->back()->with('status', 'update-error');
        }

        return redirect()->back()->with('status', 'update-success')->with('activeLayer', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyLayerRequest $request, $id)
    {
        $layer = $this->layer->getById($id);
        $mapHash = $layer->map->hash;

        $result = $this->layer->destroyLayer($id);

        if($result == 0){
            return redirect()->back()->with('status', 'destroy-error');
        }

        $toPath = "public/maps/$mapHash/$layer->id.geojson";

        if(Storage::disk('base')->exists($toPath))
        {
            Storage::disk('base')->delete($toPath);
        }

        return redirect()->back()->with('status', 'destroy-success');
    }

    /**
     * Update the order column if the specified resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(SortLayersRequest $request)
    {
        // dd($request->input());

        $result = $this->layer->sortLayers($request);

        if(!$result){
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['status' => 'error']);
            }
            return redirect()->route('admin.map.index')->with('status', 'update-error');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => 'success']);
        }
        return redirect()->route('admin.map.index')->with('status', 'update-success');
    }
}
