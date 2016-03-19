<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\SourceRepository;
use App\Models\Source;
use Storage;

class PublishSource extends Job implements ShouldQueue
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
        $this->source->sync_status = "publishing";
        $this->source->save();

        $id = $this->source->id;
        $procFilePath = 'sources/'.$id.'/p/file.processed';
        $pubFilePath = 'sources/'.$id.'/file.geojson';

        // File exists in storage/app/sources/p/file.processed ?
        if( ! Storage::exists($procFilePath) )
        {
            // update sync_status
            $this->source->sync_status = "error";

            $sourceRepo->addRecord($this->source, "Processed file in $procFilePath does not exists!", "error");
        }
        else
        {
            $result = $sourceRepo->publish($this->source, $procFilePath, $pubFilePath);

            if($result == true){
                $this->source->sync_status = "ready";
            }
            else
            {
                $this->source->sync_status = "error";
            }
        }

        $this->source->save();

        $sourceRepo->addRecord($this->source, "Source published successfully!", "success");
    }
}
