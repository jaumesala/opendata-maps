<?php

use Illuminate\Database\Seeder;

class LayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Layer::class, 50)->create();
    }
}
