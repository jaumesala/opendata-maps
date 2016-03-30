<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use App\Http\Requests\Admin\CreatePermissionRequest;
use App\Http\Requests\Admin\DestroyPermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;

class PermissionsController extends Controller
{
    /**
     * The Permission repository instance.
     *
     * @var PermissionRepository
     */
    protected $permission;


    /**
     * Create a new controller instance.
     *
     * @param  RoleRepository  $user
     * @return void
     */
    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routeName = 'permission';
        $routeMethod = 'index';

        $permissions = $this->permission->getAllOrderedBy('name');

        $data = compact('routeName', 'routeMethod', 'roles', 'permissions');

        \Clockwork::info($permissions);

        return view('admin.sections.permission.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routeName = 'permission';
        $routeMethod = 'create';

        $permissions = $this->permission->getAllOrderedBy('name');

        $data = compact('routeName', 'routeMethod', 'permissions');

        \Clockwork::info($permissions);

        return view('admin.sections.permission.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePermissionRequest $request)
    {
        $result = $this->permission->storePermission($request);

        if(!$result){
            return redirect()->back()->with('status', 'create-error');
        }

        return redirect()->route('admin.permission.index')->with('status', 'create-success');
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
        $routeName = 'permission';
        $routeMethod = 'edit';

        $permission = $this->permission->getById($id);

        $data = compact('routeName', 'routeMethod', 'permission');

        \Clockwork::info($permission);

        return view('admin.sections.permission.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $result = $this->permission->updatePermission($request);

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
    public function destroy(DestroyPermissionRequest $request, $id)
    {
        $result = $this->permission->destroyPermission($id);

        if($result < 0){
            return redirect()->back()->with('status', 'destroy-refused');
        }

        if($result == 0){
            return redirect()->back()->with('status', 'destroy-error');
        }

        return redirect()->route('admin.permission.index')->with('status', 'destroy-success');
    }
}
