<?php

namespace App\Http\Controllers\Tests;

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
        return response()->view('tests.pages.home.index', $data);
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
        return response()->view('tests.pages.neighborhoods.index', $data);
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
        return response()->view('tests.pages.complains.index', $data);
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
        return response()->view('tests.pages.choropleth.index', $data);
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
        return response()->view('tests.pages.heatmap.index', $data);
    }
}
