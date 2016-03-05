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
        );

        // Uncomment the below to run the seeder
        DB::table('settings')->insert($settings);


        factory(App\Models\Setting::class, 10)->create();


    }
}
