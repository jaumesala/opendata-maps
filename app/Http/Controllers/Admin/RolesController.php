<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\DestroyRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;

class RolesController extends Controller
{
    /**
     * The Role repository instance.
     *
     * @var UserRepository
     */
    protected $role;

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
    public function __construct(RoleRepository $role, PermissionRepository $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routeName = 'role';
        $routeMethod = 'index';

        $roles = $this->role->getAllOrderedBy('name');

        $data = compact('routeName', 'routeMethod', 'roles');

        \Clockwork::info($roles);

        return view('admin.sections.role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routeName = 'role';
        $routeMethod = 'create';

        $permissions = $this->permission->getAllOrderedBy('name');

        $data = compact('routeName', 'routeMethod', 'permissions');

        \Clockwork::info($permissions);

        return view('admin.sections.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        $result = $this->role->storeRole($request);

        if(!$result){
            return redirect()->back()->with('status', 'create-error');
        }

        return redirect()->route('admin.role.index')->with('status', 'create-success');
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
        $routeName = 'role';
        $routeMethod = 'edit';

        $role = $this->role->getById($id);
        $permissions = $this->permission->getAllOrderedBy('name');

        $data = compact('routeName', 'routeMethod', 'role', 'permissions');

        \Clockwork::info($permissions);

        return view('admin.sections.role.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $result = $this->role->updateRole($request);

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
    public function destroy(DestroyRoleRequest $request, $id)
    {
        $result = $this->role->destroyRole($id);

        if($result < 0){
            return redirect()->back()->with('status', 'destroy-refused');
        }

        if($result == 0){
            return redirect()->back()->with('status', 'destroy-error');
        }

        return redirect()->route('admin.role.index')->with('status', 'destroy-success');
    }
}
