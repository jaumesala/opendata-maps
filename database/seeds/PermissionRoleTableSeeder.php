<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pIds = Permission::lists('id');

        //superadmin
        foreach($pIds as $id){
            DB::table('permission_role')->insert([
                'permission_id'   => $id,
                'role_id'   => 1
            ]);
        }

        //admin
        DB::table('permission_role')->insert([
            [   'permission_id'   => 1,
                'role_id'   => 2 ],
            [   'permission_id'   => 2,
                'role_id'   => 2 ],
            [   'permission_id'   => 3,
                'role_id'   => 2 ],
            [   'permission_id'   => 4,
                'role_id'   => 2 ],
            [   'permission_id'   => 6,
                'role_id'   => 2 ],
            [   'permission_id'   => 11,
                'role_id'   => 2 ],
            [   'permission_id'   => 13,
                'role_id'   => 2 ],
            [   'permission_id'   => 16,
                'role_id'   => 2 ],
            [   'permission_id'   => 17,
                'role_id'   => 2 ],
            [   'permission_id'   => 18,
                'role_id'   => 2 ],
            [   'permission_id'   => 19,
                'role_id'   => 2 ],
            [   'permission_id'   => 21,
                'role_id'   => 2 ],
            [   'permission_id'   => 22,
                'role_id'   => 2 ],
            [   'permission_id'   => 23,
                'role_id'   => 2 ],
            [   'permission_id'   => 24,
                'role_id'   => 2 ],
        ]);

        //editor
        DB::table('permission_role')->insert([
            [   'permission_id'   => 1,
                'role_id'   => 3 ],
            [   'permission_id'   => 3,
                'role_id'   => 3 ],
            [   'permission_id'   => 6,
                'role_id'   => 3 ],
            [   'permission_id'   => 8,
                'role_id'   => 3 ],
            [   'permission_id'   => 11,
                'role_id'   => 3 ],
            [   'permission_id'   => 13,
                'role_id'   => 3 ],
            [   'permission_id'   => 16,
                'role_id'   => 3 ],
            [   'permission_id'   => 18,
                'role_id'   => 3 ],
            [   'permission_id'   => 21,
                'role_id'   => 3 ],
            [   'permission_id'   => 23,
                'role_id'   => 3 ],
        ]);

    }
}
