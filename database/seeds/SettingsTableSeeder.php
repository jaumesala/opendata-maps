<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = array(
            [   'group'  => 'mapbox',
                'key' => 'accessToken',
                'value'  => 'pk.eyJ1IjoiamF1bWVzYWxhIiwiYSI6ImNpanZ4dmlndDAwNWl2Mm00d3RpY2VweTkifQ.fh0cb8ZJhawwDnZUlZx47Q',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'group'  => 'mapbox',
                'key' => 'mapboxStyles',
                'value'  => 'https://api.tiles.mapbox.com/mapbox-gl-js/v0.14.2/mapbox-gl.css',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'group'  => 'mapbox',
                'key' => 'mapboxScripts',
                'value'  => 'https://api.tiles.mapbox.com/mapbox-gl-js/v0.14.1/mapbox-gl.js',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'group'  => 'mapbox',
                'key' => 'turfScripts',
                'value'  => 'https://api.mapbox.com/mapbox.js/plugins/turf/v2.0.2/turf.min.js',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'group'  => 'maps',
                'key' => 'defaultOrder',
                'value'  => 'created_at',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'group'  => 'maps',
                'key' => 'pageResults',
                'value'  => 12,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'group'  => 'sources',
                'key' => 'defaultOrder',
                'value'  => 'created_at',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'group'  => 'sources',
                'key' => 'pageResults',
                'value'  => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
        );

        // Uncomment the below to run the seeder
        DB::table('settings')->insert($settings);


        // factory(App\Models\Setting::class, 10)->create();


    }
}
