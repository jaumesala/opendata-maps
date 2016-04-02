<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\LayerRepository;
// use App\Repositories\MapRepository;
use App\Http\Requests\Admin\CreateLayerRequest;
use App\Http\Requests\Admin\DestroyLayerRequest;
use App\Http\Requests\Admin\UpdateLayerRequest;

class LayersController extends Controller
{
    /**
     * The Layer repository instance.
     *
     * @var LayerRepository
     */
    protected $layer;

    /**
     * Create a new controller instance.
     *
     * @param  LayerRepository  $layer
     * @return void
     */
    public function __construct(LayerRepository $layer)
    {
        $this->layer = $layer;

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
        $result = $this->layer->storeLayer($request);

        if(!$result){
            return redirect()->back()->with('status', 'create-error');
        }

        return redirect()->route('admin.map.edit', $result->map_id)->with('status', 'create-success');
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
        // $result = $this->layer->updateLayer($request);

        // if(!$result){
        //     return redirect()->back()->with('status', 'update-error');
        // }

        // return redirect()->back()->with('status', 'update-success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DestroyLayerRequest $request)
    {
        $result = $this->layer->destroyLayer($id);

        if($result == 0){
            return redirect()->back()->with('status', 'destroy-error');
        }

        return redirect()->back()->with('status', 'destroy-success');
    }
}
