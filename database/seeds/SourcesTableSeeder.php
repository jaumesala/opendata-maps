<?php

use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sources = array(
            [   'origin_type' => 'url',
                'origin_url' => 'http://www.dataplatform.nl/dataset/6f219433-15c4-468b-91b4-8610710a987e/resource/0cb2d09a-b4b9-412a-bd98-c5934291107e/download/wijken-en-buurten-schiedam.geojson',
                'origin_format' => null,
                'origin_size' => null,
                'name' => 'Neighborhoods',
                'description' => 'Schiedam neighborhoods',
                'web' => '',
                'sync_status' => 'queued',
                'sync_interval' => 'never',
                'synced_at' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
        );

        // Uncomment the below to run the seeder
        DB::table('sources')->insert($sources);


        factory(App\Models\Source::class, 40)->create();
    }
}
