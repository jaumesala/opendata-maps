<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\SourceRepository;

class SourceSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "source:sync";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the sources';

    /**
     * The source repository.
     *
     * @var SourceRepository
     */
    protected $source;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SourceRepository $source)
    {
        parent::__construct();

        $this->source = $source;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->source->syncAllSources();
    }
}
