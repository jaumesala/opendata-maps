<?php

namespace App\Http\Controllers\Pub;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\MapRepository;
use Auth;

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
     * Display the specified resource.
     *
     * @param  int  $hash
     * @return \Illuminate\Http\Response
     */
    public function show($hash, Request $request)
    {
        $routeName = 'map';
        $routeMethod = 'show';

        $map = $this->map->getByHash($hash);

        if(!$map){
            $data = compact('routeName', 'routeMethod');
            return view('public.sections.map.unavailable', $data);
        }

        if($request->input('redirect') == null){
            if(Auth::check()){
                return redirect()->route('admin.map.show', $map->id);
            }
        }

        $this->map->countView($map);

        $environment = collect([
                'settings' => \Cache::get('settings'),
                // 'sources' => $sources
            ]);

        $data = compact('routeName', 'routeMethod', 'map', 'environment');

        \Clockwork::info($map);

        return view('public.sections.map.show', $data);
    }
}
