<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\MapRepository;
use App\Repositories\TagRepository;
use App\Http\Requests\Admin\CreateMapRequest;
// use App\Http\Requests\Admin\DestroySourceRequest;
// use App\Http\Requests\Admin\UpdateSourceRequest;

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
            $order = 'created_at';
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


        $data = compact('routeName', 'routeMethod', 'tags');

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
        // dd($request->input());
        if($request->has('id') && intval($request->id) != 0)
        {
            return $this->update($request);
        }

        $result = $this->map->storeMap($request);

        if(!$result){
            return redirect()->back()->with('status', 'create-error');
        }

        return redirect()->back()->with('status', 'create-success');
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
    public function edit($id)
    {
        // $routeName = 'users';
        // $routeMethod = 'edit';

        // $user = $this->user->getById($id);
        // $roles = $this->role->getAllOrderedBy('name');

        // $data = compact('routeName', 'routeMethod', 'user', 'roles');

        // \Clockwork::info($user);

        // return view('admin.sections.user.edit', $data);
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
        // $result = $this->user->updateUser($request);

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
    public function destroy($id, DestroyMapRequest $request)
    {
        // $result = $this->user->destroyUser($id);

        // if($result < 0){
        //     return redirect()->back()->with('status', 'destroy-refused');
        // }

        // if($result == 0){
        //     return redirect()->back()->with('status', 'destroy-error');
        // }

        // return redirect()->route('admin.user.index')->with('status', 'destroy-success');
    }
}
