<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Http\Requests\Admin\CreateSettingRequest;
use App\Http\Requests\Admin\DestroySettingRequest;

class SettingsController extends Controller
{
    /**
     * The Setting repository instance.
     *
     * @var SettingRepository
     */
    protected $setting;

    /**
     * Create a new controller instance.
     *
     * @param  SettingRepository  $setting
     * @return void
     */
    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routeName = 'settings';
        $routeMethod = 'index';

        $settings = $this->setting->getAllByGroupOrdered();

        $data = compact('routeName', 'routeMethod', 'settings');

        \Clockwork::info($settings);

        return view('admin.sections.settings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSettingRequest $request)
    {
        $result = $this->setting->storeSetting($request);

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update multiple resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $group
     * @return \Illuminate\Http\Response
     */
    public function updateGroup(UpdateSettingsRequest $request)
    {
        $group = $request->input('group');
        $settings = $request->input('settings');

        $result = $this->setting->updateSettingsByGroup($group, $settings);

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
    public function destroy($id, DestroySettingRequest $request)
    {
        $result = $this->setting->destroySetting($request);

        if(!$result){
            return redirect()->back()->with('status', 'destroy-error');
        }

        return redirect()->back()->with('status', 'destroy-success');

    }
}
