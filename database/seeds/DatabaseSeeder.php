<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(SourcesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(MapsTableSeeder::class);
        $this->call(LayersTableSeeder::class);
    }
}
