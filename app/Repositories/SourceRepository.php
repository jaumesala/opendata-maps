<?php

namespace App\Repositories;

use App\Models\Source;
use App\Models\Record;
// use GuzzleHttp\Client as GuzzleClient;
// use GuzzleHttp\Promise as GuzzlePromise;
// use Psr\Http\Message\ResponseInterface;
use Log;
use Symfony\Component\Process\Process;
use Storage;


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
        $sources = Source::orderBy($column, $order)->paginate(setting_value('sources', 'pageResults'));

        return $sources;
    }

    public function getQueryPageOrderedBy($query = '', $column = 'id', $order = 'asc')
    {
        $sources = Source::where('name', 'like', '%'.$query.'%')->orderBy($column, $order)->paginate(setting_value('sources', 'pageResults'));

        return $sources;
    }

    public function getRemoteFileInfo($url = null)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->head($url);

        $result['status']   = $response->getStatusCode();

        if( $response->getStatusCode() == 200 ) {

            $result['size'] =  $this->guessResponseLength($response);

            $result['type'] = $this->guessResponseType($response, $url);

        }

        return $result;
    }

    public function guessResponseType($response, $url)
    {
        $mimes = [
            'csv'       => 'text/csv',
            'txt'       => 'text/plain',
            'json'      => 'application/json',
            // 'xml'       => 'application/xml',
            'geojson'   => 'application/vnd.geo+json',
            'kml'       => 'application/vnd.google-earth.kml+xml',
            // 'kmz'       => 'application/vnd.google-earth.kmz',
            'gpx'       => 'application/gpx+xml'
        ];

        // try to find the content type of the response
        if(!$response->hasHeader('content-type')){
            return 'unknown';
        }

        if(is_array($response->getHeader('content-type'))){
            $contentType = $response->getHeader('content-type')[0];
        } else {
            $contentType = $response->getHeader('content-type');
        }

        // find content type in accepted mimes array
        $mimeType = array_search($contentType, $mimes);

        // if not in list, try to guess from file extension
        if(!$mimeType){
            $arrUrl = explode(".",$url);
            $extension = end($arrUrl);

            if(array_key_exists($extension, $mimes)) {
                return $extension;
            }
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
        $source = new Source();

        //create public hash
        $hash = "";
        do
        {
            $hash = str_random(4);
        }
        while (Source::where("hash", "=", $hash)->first() instanceof Source);
        $source->hash = $hash;

        $source->hash = $hash;
        $source->origin_type = $request->origin_type;
        $source->origin_url = $request->origin_url;
        $source->origin_file = null;
        $source->origin_format = null;
        $source->origin_size = null;
        $source->name = $request->name;
        $source->description = $request->description ? $request->description : '';
        $source->web = $request->web ? $request->web : '';
        $source->sync_status = 'queued';
        $source->sync_interval = $request->sync_interval ? $request->sync_interval : 'never';
        $source->synced_at = null;

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
            'web' => $request->web ? $request->web : '',
            'sync_interval' => $request->sync_interval ? $request->sync_interval : $model->sync_interval,
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

    public function convertToGeoJSON($source = null, $rawPath = null, $procPath = null)
    {
        if(!$source) return false;
        if(!$rawPath) return false;
        if(!$procPath) return false;

        $originMimeType = $source->origin_format;
        $process = $this->getProcess();
        $result = null;

        switch($originMimeType){
            case 'csv':

                $this->addRecord($source, "Converting CSV to GeoJSON");
                if(Storage::exists($procPath))
                {
                    Storage::delete($procPath);
                }
                $process->setCommandLine(trim("csv2geojson $rawPath > $procPath"));

                try
                {
                    $process->mustRun();
                    $output = $process->getOutput();

                    if($process->isSuccessful() && $output == "")
                    {
                        $this->addRecord($source, "CSV to GeoJSON convertion succeed", "success");
                        $result = true;
                    }
                    else
                    {
                        $result = false;

                        // Log::info("CSV to GeoJSON convertion failed with output: $output");
                        $this->addRecord($source, "CSV to GeoJSON convertion failed with output: $output", "error");

                    }

                }
                catch (ProcessFailedException $e)
                {
                    $error = $e->getMessage();

                    $result = false;

                    // Log::info("CSV to GeoJSON failed with error: $error");
                    $this->addRecord($source, "CSV to GeoJSON convertion failed with error: $error", "error");
                }

                break;

            case 'kml':

                // Log::info("Converting KML to GeoJSON");
                $this->addRecord($source, "Converting KML to GeoJSON");
                if(Storage::exists($procPath))
                {
                    Storage::delete($procPath);
                }
                $process->setCommandLine(trim("togeojson -f kml $rawPath > $procPath"));

                try
                {
                    $process->mustRun();
                    $output = $process->getOutput();

                    if($process->isSuccessful() && $output == "")
                    {
                        $this->addRecord($source, "XML to GeoJSON convertion succeed", "success");
                        $result = true;
                    }
                    else
                    {
                        $result = false;

                        // Log::info("KML to GeoJSON convertion failed with output: $output");
                        $this->addRecord($source, "KML to GeoJSON convertion failed with output: $output", "error");
                    }

                }
                catch (ProcessFailedException $e)
                {
                    $error = $e->getMessage();

                    $result = false;

                    // Log::info("KML to GeoJSON failed with error: $error");
                    $this->addRecord($source, "KML to GeoJSON convertion failed with error: $error", "error");
                }

                break;

            case 'gpx':

                // Log::info("Converting GPX to GeoJSON");
                $this->addRecord($source, "Converting GPX to GeoJSON");
                if(Storage::exists($procPath))
                {
                    Storage::delete($procPath);
                }
                $process->setCommandLine(trim("togeojson -f gpx $rawPath > $procPath"));

                try
                {
                    $process->mustRun();
                    $output = $process->getOutput();

                    if($process->isSuccessful() && $output == "")
                    {
                        $this->addRecord($source, "GPX to GeoJSON convertion succeed", "success");
                        $result = true;
                    }
                    else
                    {
                        $result = false;

                        // Log::info("GPX to GeoJSON convertion failed with output: $output");
                        $this->addRecord($source, "GPX to GeoJSON convertion failed with output: $output", "error");
                    }

                }
                catch (ProcessFailedException $e)
                {
                    $error = $e->getMessage();

                    $result = false;

                    // Log::info("GPX to GeoJSON failed with error: $error");
                    $this->addRecord($source, "GPX to GeoJSON failed with error: $error", "error");
                }

                break;

            case 'json':
            case 'geojson':

                // Log::info("Verifying GeoJSON file format");
                $this->addRecord($source, "Verifying GeoJSON file format");

                $process->setCommandLine(trim("geojsonhint < $rawPath"));

                try
                {
                    $process->mustRun();
                    $output = $process->getOutput();

                    if($process->isSuccessful() && $output == "")
                    {
                        $result = true;
                        $this->addRecord($source, "GeoJSON verification succeed", "success");
                        if(Storage::exists($procPath))
                        {
                            Storage::delete($procPath);
                        }
                        Storage::copy($rawPath, $procPath);
                        $this->addRecord($source, "Copied raw file to processed path", "info");

                    }
                    else
                    {
                        $result = false;

                        // Log::info("GeoJSON verification failed with output: $output");
                        $this->addRecord($source, "GeoJSON verification failed with output: $output", "error");
                    }

                }
                catch (ProcessFailedException $e)
                {
                    $error = $e->getMessage();

                    $result = false;

                    // Log::info("GeoJSON failed verification with error: $error");
                    $this->addRecord($source, "GeoJSON verification failed with error: $error", "error");

                }

                break;

            case 'txt':
            default:
                // Log::info("Mime type $originMimeType of source $name ($id) not suported!");
                $this->addRecord($source, "Mime type $originMimeType not suported!", "warning");
        }
        return $result;
    }

    public function destroySource($id)
    {
        $source = Source::findOrFail($id);

        //if source has maps return -1

        $result = Source::destroy($id);

        return $result;
    }

    public function getAllRecords($source = null, $column = 'created_at', $order = 'desc')
    {

        if(is_object($source))
        {
            $source = $source->id;
        }

        $records =  Record::where('source_id', $source)->orderBy($column, $order)->orderBy('id', $order)->get();

        return $records;
    }

    public function addRecord($source = null, $message="", $level = "muted")
    {
        $record = new Record;
        $record->source_id = $source->id;
        $record->message = $message;
        $record->level = $level;

        return $record->save();
    }

    /**
     * Get a new Symfony process instance.
     *
     * @return \Symfony\Component\Process\Process
     */
    public function getProcess()
    {
        return (new Process('', storage_path('app')))->setTimeout(null);
    }

    public function publish($source = null, $procPath = null, $pubPath = null)
    {
        if(!$source) return false;
        if(!$procPath) return false;
        if(!$pubPath) return false;

        $result = null;
        if(Storage::disk('base')->exists($pubPath))
        {
            Storage::disk('base')->delete($pubPath);
        }

        $result = Storage::disk('base')->copy($procPath, $pubPath);

        return $result;
    }

}