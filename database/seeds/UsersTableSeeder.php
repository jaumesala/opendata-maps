<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [   'name'  => 'Jaume Sala',
                'email' => 'jaumesala@gmail.com',
                'password'  => '$2y$10$WTvUKIIZcUxSE3NjcMoQg.pOIprPrrvNMqS4S2YtuvQDzjrMBkT6e',
                'api_token' => str_random(60),
                'remember_token' => str_random(10),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'name'  => 'schideam',
                'email' => 'maps@schiedam.xyz',
                'password'  => Hash::make('schiedam'),
                'api_token' => str_random(60),
                'remember_token' => str_random(10),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
        );

        // Uncomment the below to run the seeder
        DB::table('users')->insert($users);
    }
}
