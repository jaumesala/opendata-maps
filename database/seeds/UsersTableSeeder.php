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
            [   'name'  => env('SUPERADMIN_NAME', 'Super Admin'),
                'email' => env('SUPERADMIN_EMAIL', 'superadmin@opendata-maps.app'),
                'password'  => Hash::make(env('SUPERADMIN_PASSWORD', 'superadmin')),
                'api_token' => str_random(60),
                'remember_token' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'name'  => 'admin',
                'email' => 'admin@opendata-maps.app',
                'password'  => Hash::make('admin'),
                'api_token' => str_random(60),
                'remember_token' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            [   'name'  => 'editor',
                'email' => 'editor@opendata-maps.app',
                'password'  => Hash::make('editor'),
                'api_token' => str_random(60),
                'remember_token' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
        );

        // Uncomment the below to run the seeder
        DB::table('users')->insert($users);
    }
}
