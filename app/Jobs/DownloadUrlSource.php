<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Repositories\SourceRepository;
use App\Models\Source;
use Carbon\Carbon;
use Log;
use App\Jobs\ConvertSource;

class DownloadUrlSource extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

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
        $name = $this->source->name;
        $url = $this->source->origin_url;

        $sourceRepo->addRecord($this->source, "Starting download");

        $response = $sourceRepo->copyRemoteFile($url, storage_path('app/sources/'.$id.'/o/file.raw'));

        if(!$response)
        {
            // update sync_status
            $this->source->sync_status = "error";

            $sourceRepo->addRecord($this->source, "No response received from server origin", "error");
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

            // Queue the source to be converted
            $this->dispatch(new ConvertSource($this->source));

            $sourceRepo->addRecord($this->source, "Download success!", "success");
        }
        else
        {
            // update sync_status
            $this->source->sync_status = "error";

            $statusCode = $response->getStatusCode();

            $sourceRepo->addRecord($this->source, "Server origin respondend with status code $statusCode while downloading". "error");
        }

        $this->source->save();
    }
}
