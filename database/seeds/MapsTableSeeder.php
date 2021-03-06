<?php

use Illuminate\Database\Seeder;

class MapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Map::class, 20)->create()->each(function($map) {
            $map->tags()->sync(
                App\Models\Tag::all()->random(3)
            );
        });
    }
}
