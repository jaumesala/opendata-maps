<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\MapRepository;
use App\Repositories\TagRepository;
use App\Repositories\SourceRepository;
use App\Http\Requests\Admin\CreateMapRequest;
use App\Http\Requests\Admin\DestroyMapRequest;
use App\Http\Requests\Admin\UpdateMapRequest;
use Storage;

class MapsController extends Controller
{
    /**
     * The Map repository instance.
     *
     * @var MapRepository
     */
    protected $map;

    /**
     * Create a new controller instance.
     *
     * @param  MapRepository  $map
     * @return void
     */
    public function __construct(MapRepository $map)
    {
        $this->map = $map;

        $this->middleware('permission:list-maps', ['only' => [ 'index' ]]);
        $this->middleware('permission:create-map', ['only' => [ 'create', 'store' ]]);
        $this->middleware('permission:show-map', ['only' => [ 'show' ]]);
        $this->middleware('permission:edit-map', ['only' => [ 'edit', 'update' ]]);
        $this->middleware('permission:destroy-map', ['only' => [ 'destroy' ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $routeName = 'map';
        $routeMethod = 'index';

        if(in_array($request->input('order', ''), ['status', 'name', 'views', 'created_at', 'updated_at'])){
            $order = $request->input('order');
        } else {
            $order = setting_value('maps', 'defaultOrder');
        }

        if($request->has('query')){
            $query = $request->input('query');
            $maps = $this->map->getQueryPageOrderedBy($query, $order, 'desc');
        } else {
            $maps = $this->map->getPageOrderedBy($order, 'desc');
        }

        $data = compact('routeName', 'routeMethod', 'maps');

        \Clockwork::info($maps);

        return view('admin.sections.map.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TagRepository $tag)
    {
        $routeName = 'map';
        $routeMethod = 'create';

        $tags = $tag->getAllOrderedBy('name');

        $environment = collect([
                'settings' => \Cache::get('settings')
            ]);

        $environment = $environment->toJSON();


        $data = compact('routeName', 'routeMethod', 'tags', 'environment');

        \Clockwork::info($data);

        return view('admin.sections.map.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMapRequest $request)
    {
        $result = $this->map->storeMap($request);

        if(!$result){
            return redirect()->back()->with('status', 'create-error');
        }

        return redirect()->route('admin.map.edit', $result->id)->with('status', 'create-success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $routeName = 'map';
        $routeMethod = 'show';

        $map = $this->map->getById($id);

        if(!$map){
            return redirect()->route('admin.map.index');
        }

        $data = compact('routeName', 'routeMethod', 'map');

        \Clockwork::info($map);

        return view('admin.sections.map.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TagRepository $tag, SourceRepository $source, $id)
    {
        $routeName = 'map';
        $routeMethod = 'edit';

        $map = $this->map->getById($id);
        $tags = $tag->getAllOrderedBy('name');
        $sources = $source->getAllOrderedBy('name');

        $environment = collect([
                'settings' => \Cache::get('settings'),
                // 'sources' => $sources
            ]);

        $environment = $environment->toJSON();

        $data = compact('routeName', 'routeMethod', 'map', 'tags', 'sources', 'environment');

        \Clockwork::info($data);

        return view('admin.sections.map.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMapRequest $request, $id)
    {
        $result = $this->map->updateMap($request);

        if(!$result){
            return redirect()->back()->with('status', 'update-error');
        }

        return redirect()->back()->with('status', 'update-success');
    }


    /**
     * Disable the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        $map = $this->map->getById($id);

        if(!$map){
            return redirect()->route('admin.map.index');
        }

        $result = $this->map->disableMap($map->id);

        if(!$result){
            return redirect()->back()->with('status', 'update-error');
        }

        return redirect()->back()->with('status', 'update-success');
    }


    /**
     * Enable the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enable($id)
    {
        $map = $this->map->getById($id);

        if(!$map){
            return redirect()->route('admin.map.index');
        }

        $result = $this->map->enableMap($map->id);

        if(!$result){
            return redirect()->back()->with('status', 'update-error');
        }

        return redirect()->back()->with('status', 'update-success');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DestroyMapRequest $request)
    {
        $result = $this->map->destroyMap($id);

        if($result == 0){
            return redirect()->back()->with('status', 'destroy-error');
        }

        return redirect()->route('admin.map.index')->with('status', 'destroy-success');
    }
}
