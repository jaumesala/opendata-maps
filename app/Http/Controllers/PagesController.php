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
        return response()->view('public.pages.home.index', $data);
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
        return response()->view('public.pages.neighborhoods.index', $data);
    }

    /**
     * Display Complains page.
     *
     * @return Response
     */
    public function getComplains()
    {
        $routeName = "complains";
        $routeMethod = "index";


        $data = compact('routeName', 'routeMethod');
        return response()->view('public.pages.complains.index', $data);
    }

    /**
     * Display choropleth page.
     *
     * @return Response
     */
    public function getChoropleth()
    {
        $routeName = "choropleth";
        $routeMethod = "index";


        $data = compact('routeName', 'routeMethod');
        return response()->view('public.pages.choropleth.index', $data);
    }

    /**
     * Display heatmap page.
     *
     * @return Response
     */
    public function getHeatmap()
    {
        $routeName = "heatmap";
        $routeMethod = "index";


        $data = compact('routeName', 'routeMethod');
        return response()->view('public.pages.heatmap.index', $data);
    }
}
