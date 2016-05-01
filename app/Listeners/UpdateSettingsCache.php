<?php

namespace App\Listeners;

use App\Events\SettingsWereModified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Cache;
use App\Repositories\SettingRepository;

class UpdateSettingsCache
{

    /**
     * The Setting repository.
     *
     * @var Source
     */
    protected $setting;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Handle the event.
     *
     * @param  SettingsWereModified  $event
     * @return void
     */
    public function handle(SettingsWereModified $event)
    {
        Cache::forever('settings', $this->setting->getCacheMap() );
    }
}
