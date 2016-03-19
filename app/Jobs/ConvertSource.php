<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Repositories\SourceRepository;
use App\Models\Source;
use Symfony\Component\Process\Process;
use Storage;
use App\Jobs\PublishSource;

class ConvertSource extends Job implements ShouldQueue
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
        $this->source->sync_status = "processing";
        $this->source->save();

        $id = $this->source->id;
        $rawFilePath = 'sources/'.$id.'/o/file.raw';
        $procFilePath = 'sources/'.$id.'/p/file.processed';

        // File exists in storage/app/sources/XX/o/file.raw ?
        if( ! Storage::exists($rawFilePath) )
        {
            // update sync_status
            $this->source->sync_status = "error";

            $sourceRepo->addRecord($this->source, "Raw file in $rawFilePath does not exists!", "error");
        }
        elseif( Storage::mimeType($rawFilePath) != 'text/plain' )
        {
            // update sync_status
            $this->source->sync_status = "error";

            $fileMimeType = Storage::mimeType($rawFilePath);

            $sourceRepo->addRecord($this->source, "Mime type $fileMimeType of file in $rawFilePath not supported!", "error");
        }
        else
        {
            $result = $sourceRepo->convertToGeoJSON($this->source, $rawFilePath, $procFilePath);

            if($result == true)
            {
                $this->source->sync_status = "processed";

                // Queue the source to be published
                $this->dispatch(new PublishSource($this->source));
            }
            else
            {
                $this->source->sync_status = "error";
            }
        }

        $this->source->save();

        $sourceRepo->addRecord($this->source, "Source processed successfully!", "success");
    }

}
