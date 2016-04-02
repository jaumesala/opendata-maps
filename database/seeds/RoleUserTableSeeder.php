<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = [
            [   'user_id'   => 1,
                'role_id'   => 1
                ],
            [   'user_id'   => 1,
                'role_id'   => 2
                ],

            [   'user_id'   => 2,
                'role_id'   => 2
                ],

            [   'user_id'   => 3,
                'role_id'   => 3
                ],
        ];

        // Uncomment the below to run the seeder
        DB::table('role_user')->insert($role_user);
    }
}
