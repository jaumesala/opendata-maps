<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\DestroyUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class UsersController extends Controller
{
    /**
     * The User repository instance.
     *
     * @var UserRepository
     */
    protected $user;

    /**
     * The Role repository instance.
     *
     * @var UserRepository
     */
    protected $role;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $user
     * @return void
     */
    public function __construct(UserRepository $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;

        $this->middleware('permission:list-users', ['only' => [ 'index' ]]);
        $this->middleware('permission:create-user', ['only' => [ 'create', 'store' ]]);
        $this->middleware('permission:show-user', ['only' => [ 'show' ]]);
        $this->middleware('permission:edit-user', ['only' => [ 'edit', 'update' ]]);
        $this->middleware('permission:destroy-user', ['only' => [ 'destroy' ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routeName = 'user';
        $routeMethod = 'index';

        $users = $this->user->getAllOrderedBy('name');

        $data = compact('routeName', 'routeMethod', 'users');

        \Clockwork::info($users);

        return view('admin.sections.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routeName = 'user';
        $routeMethod = 'create';

        $roles = $this->role->getAllOrderedBy('name');

        $data = compact('routeName', 'routeMethod', 'roles');

        \Clockwork::info($roles);

        return view('admin.sections.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $result = $this->user->storeUser($request);

        if(!$result){
            return redirect()->back()->with('status', 'create-error');
        }

        return redirect()->route('admin.user.index')->with('status', 'create-success');
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
        $routeName = 'user';
        $routeMethod = 'edit';

        $user = $this->user->getById($id);
        $roles = $this->role->getAllOrderedBy('name');

        $data = compact('routeName', 'routeMethod', 'user', 'roles');

        \Clockwork::info($user);

        return view('admin.sections.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $result = $this->user->updateUser($request);

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
    public function destroy(DestroyUserRequest $request, $id)
    {
        $result = $this->user->destroyUser($id);

        if($result < 0){
            return redirect()->back()->with('status', 'destroy-refused');
        }

        if($result == 0){
            return redirect()->back()->with('status', 'destroy-error');
        }

        return redirect()->route('admin.user.index')->with('status', 'destroy-success');
    }
}
