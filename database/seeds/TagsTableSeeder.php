<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tags = array(
            [   'name'          => 'environment',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
                ],
            [   'name' => 'government',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
                ],
        );

        // Uncomment the below to run the seeder
        DB::table('tags')->insert($tags);


        factory(App\Models\Tag::class, 10)->create();
    }
}
