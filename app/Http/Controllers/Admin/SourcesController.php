<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SourceRepository;
use App\Http\Requests\Admin\CreateSourceRequest;
use App\Http\Requests\Admin\DestroySourceRequest;
use App\Http\Requests\Admin\UpdateSourceRequest;
use App\Jobs\DownloadUrlSource;
use App\Jobs\ConvertSource;
use Storage;

class SourcesController extends Controller
{
    /**
     * The Source repository instance.
     *
     * @var SourceRepository
     */
    protected $source;

    /**
     * Create a new controller instance.
     *
     * @param  MapRepository  $map
     * @return void
     */
    public function __construct(SourceRepository $source)
    {
        $this->source = $source;

        $this->middleware('permission:list-sources', ['only' => [ 'index' ]]);
        $this->middleware('permission:create-source', ['only' => [ 'create', 'store', 'checkUrl' ]]);
        $this->middleware('permission:show-source', ['only' => [ 'show' ]]);
        $this->middleware('permission:edit-source', ['only' => [ 'edit', 'update' ]]);
        $this->middleware('permission:destroy-source', ['only' => [ 'destroy' ]]);
        $this->middleware('permission:sync-sources', ['only' => [ 'sync' ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $routeName = 'source';
        $routeMethod = 'index';

        if(in_array($request->input('order', ''), ['origin_type', 'origin_format', 'origin_size', 'name', 'sync_status', 'synced_at', 'created_at', 'updated_at'])){
            $order = $request->input('order');
            $direction = 'asc';
        } else {
            $order = setting_value('sources', 'defaultOrder');
            $direction = 'desc';
        }

        if($request->has('query')){
            $query = $request->input('query');
            $sources = $this->source->getQueryPageOrderedBy($query, $order, $direction);
        } else {
            $sources = $this->source->getPageOrderedBy($order, $direction);
        }

        $data = compact('routeName', 'routeMethod', 'sources');

        \Clockwork::info($sources);

        return view('admin.sections.source.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routeName = 'source';
        $routeMethod = 'create';

        $data = compact('routeName', 'routeMethod');

        return view('admin.sections.source.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSourceRequest $request)
    {
        $source = $this->source->storeSource($request);

        if(!$source){
            return redirect()->back()->with('status', 'create-error');
        } else {

            //create directory structure
            Storage::makeDirectory('sources/'.$source->id.'/o');
            Storage::makeDirectory('sources/'.$source->id.'/p');

            $type = $request->origin_type;

             switch($type)
            {
                case 'url':
                    // Queue remote file download
                    $this->dispatch(new DownloadUrlSource($source));
                    break;

                case 'file':
                    //move temp file to raw path
                    if ($request->hasFile('origin_file'))
                    {
                        $source->origin_format = $request->file('origin_file')->getClientOriginalExtension();
                        $source->origin_size = $request->file('origin_file')->getClientSize();
                        $source->origin_file = $request->file('origin_file')->getClientOriginalName();
                        $source->save();

                        $request->file('origin_file')->move(storage_path('app/sources/'.$source->id.'/o'), 'file.raw');

                        // Queue the source to be converted
                        $this->dispatch(new ConvertSource($source));
                    }
                    break;

                default:
            }


        }

        return redirect()->route('admin.source.index')->with('status', 'create-success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $routeName = 'source';
        $routeMethod = 'show';

        $source = $this->source->getById($id);
        $records = $this->source->getAllRecords($source);

        $data = compact('routeName', 'routeMethod', 'source', 'records');

        \Clockwork::info($source);

        return view('admin.sections.source.show', $data);
    }

    /**
     * Syncs the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sync($id)
    {
        $source = $this->source->getById($id);

        if(!$source){
            return redirect()->back()->with('status', 'sync-error');
        }

        //create directory structure (in case it doesn't exists)
        Storage::makeDirectory('sources/'.$source->id.'/o');
        Storage::makeDirectory('sources/'.$source->id.'/p');

        $this->dispatch(new DownloadUrlSource($source));

        return redirect()->route('admin.source.index')->with('status', 'sync-triggered');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $routeName = 'source';
        $routeMethod = 'edit';

        $source = $this->source->getById($id);

        $data = compact('routeName', 'routeMethod', 'source');

        \Clockwork::info($source);

        return view('admin.sections.source.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSourceRequest $request, $id)
    {
        $result = $this->source->updateSource($request);

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
    public function destroy(DestroySourceRequest $request, $id)
    {
        $result = $this->source->destroySource($id);

        if($result < 0){
            return redirect()->back()->with('status', 'destroy-refused');
        }

        if($result == 0){
            return redirect()->back()->with('status', 'destroy-error');
        }

        //remove directory structure
        Storage::deleteDirectory('sources/'.$id);

        return redirect()->route('admin.source.index')->with('status', 'destroy-success');
    }


    public function checkUrl(Request $request)
    {
        $this->validate($request, [
            'origin_url' => 'required|url|max:2048',
        ]);

        $info = $this->source->getRemoteFileInfo($request->origin_url);

        if( $info['status'] == 200 ){
            $data = [
                'data' => [
                    'fileSize' => $info['size'],
                    'fileType' => $info['type'],
                ]
            ];
        } else {
            $data = [
                'errors' => [
                    'message' => 'File not reachable or moved',
                ]
            ];
        }

        return response()->json($data,$info['status']);

    }

}
