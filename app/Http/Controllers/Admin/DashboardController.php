<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routeName = 'dashboard';
        $routeMethod = 'index';

        $users = \App\Models\User::count();
        $sources = \App\Models\Source::count();
        $maps = \App\Models\map::count();

        $data = compact('routeName', 'routeMethod', 'users', 'sources', 'maps');
        return view('admin.sections.dashboard.index', $data);
    }
}
