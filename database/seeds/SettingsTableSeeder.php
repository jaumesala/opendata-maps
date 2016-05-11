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
                'value'  => env('MAPBOX_TOKEN', 'mapbox-api-token'),
                ],
            [   'group'  => 'mapbox',
                'key' => 'username',
                'value'  => env('MAPBOX_USERNAME', 'mapbox-username'),
                ],
            [   'group'  => 'mapbox',
                'key' => 'glStyle',
                'value'  => 'https://api.tiles.mapbox.com/mapbox-gl-js/v0.18.0/mapbox-gl.css',
                ],
            [   'group'  => 'mapbox',
                'key' => 'glScript',
                'value'  => 'https://api.tiles.mapbox.com/mapbox-gl-js/v0.18.0/mapbox-gl.js',
                ],
            [   'group'  => 'mapbox',
                'key' => 'turfScript',
                'value'  => 'https://api.mapbox.com/mapbox.js/plugins/turf/v2.0.2/turf.min.js',
                ],
            [   'group'  => 'mapbox',
                'key' => 'stylesApiUrl',
                'value'  => 'https://api.mapbox.com/styles/v1/',
                ],
            [   'group'  => 'mapbox',
                'key' => 'mapsApiUrl',
                'value'  => 'https://api.mapbox.com/v4/',
                ],


            [   'group'  => 'maps',
                'key' => 'defaultOrder',
                'value'  => 'created_at',
                ],
            [   'group'  => 'maps',
                'key' => 'pageResults',
                'value'  => 12,
                ],
            [   'group'  => 'maps',
                'key' => 'defaultZoom',
                'value'  => 13,
                ],
            [   'group'  => 'maps',
                'key' => 'defaultPitch',
                'value'  => 0,
                ],
            [   'group'  => 'maps',
                'key' => 'defaultBearing',
                'value'  => 348,
                ],
            [   'group'  => 'maps',
                'key' => 'defaultLongitude',
                'value'  => 4.390819,
                ],
            [   'group'  => 'maps',
                'key' => 'defaultLatitude',
                'value'  => 51.926960,
                ],



            [   'group'  => 'sources',
                'key' => 'defaultOrder',
                'value'  => 'created_at',
                ],
            [   'group'  => 'sources',
                'key' => 'pageResults',
                'value'  => 20,
                ],

            [   'group'  => 'application',
                'key' => 'title',
                'value'  => 'Opendata Maps',
                ],
            [   'group'  => 'application',
                'key' => 'name',
                'value'  => '<b>Opendata</b>Maps',
                ],
            [   'group'  => 'application',
                'key' => 'mini-name',
                'value'  => '<b>O</b>M',
                ],

        );

        // Uncomment the below to run the seeder
        DB::table('settings')->insert($settings);


        // factory(App\Models\Setting::class, 10)->create();


    }
}
