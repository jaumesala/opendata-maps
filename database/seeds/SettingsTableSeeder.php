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
                ],
            [   'group'  => 'mapbox',
                'key' => 'username',
                'value'  => 'jaumesala',
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
                'key' => 'name',
                'value'  => '<b>Schiedam</b>Maps',
                ],

        );

        // Uncomment the below to run the seeder
        DB::table('settings')->insert($settings);


        // factory(App\Models\Setting::class, 10)->create();


    }
}
