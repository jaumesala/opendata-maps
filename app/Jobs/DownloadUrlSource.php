<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\SourceRepository;
use App\Models\Source;
use Carbon\Carbon;
use Log;

class DownloadUrlSource extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * The Source model.
     *
     * @var Source
     */
    protected $source;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SourceRepository $sourceRepo)
    {
        $this->source->sync_status = "downloading";
        $this->source->save();

        $id = $this->source->id;
        $url = $this->source->origin_url;

        $response = $sourceRepo->copyRemoteFile($url, storage_path('app/sources/'.$id.'/o/raw'));

        if(!$response)
        {
            // update sync_status
            $this->source->sync_status = "error";
        }
        elseif($response->getStatusCode() == 200)
        {
            // update origin_format
            $this->source->origin_format = $sourceRepo->guessResponseType($response);

            // update origin_size
            $this->source->origin_size = $sourceRepo->guessResponseLength($response);

            // update synced_at
            $this->source->synced_at = Carbon::now()->toDateTimeString();

            // update sync_status
            $this->source->sync_status = "downloaded";

            // Queue the source to be procesed
        }
        else
        {
            // update sync_status
            $this->source->sync_status = "error";
        }

        $this->source->save();

        Log::info("downlaoded -> trigger process?");
        // Log::info('Job triggered!!!');
    }
}
