<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Display home page.
     *
     * @return Response
     */
    public function getHome()
    {
        $routeName = "home";
        $routeMethod = "index";

        $data = compact('routeName', 'routeMethod');
        return response()->view('public.sections.home.index', $data);
    }
}
