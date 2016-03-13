<?php

namespace App\Repositories;

use App\Models\Source;
// use GuzzleHttp\Client as GuzzleClient;
// use GuzzleHttp\Promise as GuzzlePromise;
// use Psr\Http\Message\ResponseInterface;
use Log;

class SourceRepository
{
    public function getAll()
    {
        $sources = Source::all();

        return $sources;
    }


    public function getById($id)
    {
        $source = Source::findOrFail($id);

        return $source;
    }


    public function getAllOrderedBy($column = 'id', $order = 'asc')
    {
        $sources = Source::orderBy($column, $order)->get();

        return $sources;
    }

    public function getPageOrderedBy($column = 'id', $order = 'asc')
    {
        $sources = Source::orderBy($column, $order)->paginate(20);

        return $sources;
    }

    public function getQueryPageOrderedBy($query = '', $column = 'id', $order = 'asc')
    {
        $sources = Source::where('name', 'like', '%'.$query.'%')->orderBy($column, $order)->paginate(20);

        return $sources;
    }

    public function getRemoteFileInfo($url = null)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->head($url);

        $result['status']   = $response->getStatusCode();

        if( $response->getStatusCode() == 200 ) {

            $result['size'] =  $this->guessResponseLength($response);

            $result['type'] = $this->guessResponseType($response);

        }

        return $result;
    }

    public function guessResponseType($response)
    {
        $mimes = [
            'txt'       => 'text/plain',
            'json'      => 'application/json',
            'xml'       => 'application/xml',
            'geojson'   => 'application/vnd.geo+json',
            'kml'       => 'application/vnd.google-earth.kml+xml',
            'kmz'       => 'application/vnd.google-earth.kmz'
        ];

        if(!$response->hasHeader('content-type')){
            return 'unknown';
        }

        if(is_array($response->getHeader('content-type'))){
            $contentType = $response->getHeader('content-type')[0];
        } else {
            $contentType = $response->getHeader('content-type');
        }

        $mimeType = array_search($contentType, $mimes);

        if(!$mimeType){
            return 'unsupported';
        } else {
            return $mimeType;
        }
    }

    public function guessResponseLength($response)
    {
        if($response->getBody()->getSize()){
            return $response->getBody()->getSize();
        }

        if(!$response->hasHeader('content-length')){
            return null;
        }

        if(is_array($response->getHeader('content-length'))){
            $contentLength = $response->getHeader('content-length')[0];
        } else {
            $contentLength = $response->getHeader('content-length');
        }

        return intval($contentLength);
    }

    public function storeSource($request)
    {
        $source = Source::firstOrNew([
            'origin_type' => $request->origin_type,
            'origin_url' => $request->origin_url,
            'origin_format' => null,
            'origin_size' => null,
            'name' => $request->name,
            'description' => $request->description,
            'web' => $request->web,
            'sync_status' => 'queued',
            'sync_interval' => $request->sync_interval,
            'synced_at' => null
        ]);

        $source->save();

        return $source;
    }

    public function updateSource($request)
    {
        $id = $request->route('source');

        $model = Source::findOrFail($id);

        $model->fill([
            'name' => $request->name,
            'description' => $request->description,
            'web' => $request->web,
            'sync_interval' => $request->sync_interval,
            ]);

        return $model->save();
    }

    public function copyRemoteFile($url = null, $path = null)
    {
        if(!$url) return false;
        if(!$path) return false;

        try
        {
            $client = new \GuzzleHttp\Client();

            $response = $client->get($url, ['sink' => $path]);

            return $response;
        }
        // Network errors
        catch(\GuzzleHttp\Exception\RequestException $e)
        {
            if ($e->hasResponse()) {
                return $e->getResponse();
            }
            return false;
        }
        // Client errors
        catch(\GuzzleHttp\Exception\ClientException $e)
        {
            if ($e->hasResponse()) {
                return $e->getResponse();
            }
            return false;
        }
        // Server errors
        catch(\GuzzleHttp\Exception\ServerException $e)
        {
            if ($e->hasResponse()) {
                return $e->getResponse();
            }
            return false;
        }
        // Other errors
        catch(\Exception $e){
            Log::error($e);
            return false;
        }
    }

    public function destroySource($id)
    {
        $source = Source::findOrFail($id);

        //if source has maps return -1

        $result = Source::destroy($id);

        return $result;
    }
}