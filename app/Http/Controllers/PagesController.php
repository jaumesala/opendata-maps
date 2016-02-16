<?php

namespace App\Http\Controllers;

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
        return response()->view('pages.home.index', $data);
    }

   /**
     * Display Neighborhoods page.
     *
     * @return Response
     */
    public function getNeighborhoods()
    {
        $routeName = "neighborhoods";
        $routeMethod = "index";

        
        $data = compact('routeName', 'routeMethod');
        return response()->view('pages.neighborhoods.index', $data);
    }
}
