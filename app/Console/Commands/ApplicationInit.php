<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\SettingsWereModified;
use Event;

class ApplicationInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if (!$this->confirm('This will delete all the information in the database. Do you wish to continue? [y|N]')) {
            return;
        }
        $this->line('Install migration table');
        $this->call('migrate:install');

        $this->line('Create database schema');
        $this->call('migrate');

        $this->line('Seed database schema');
        $this->info('Permissions');
        $this->call('db:seed', [ '--class' => 'PermissionsTableSeeder']);
        $this->info('Roles');
        $this->call('db:seed', [ '--class' => 'RolesTableSeeder']);
        $this->info('Permissions-Roles');
        $this->call('db:seed', [ '--class' => 'PermissionRoleTableSeeder']);
        $this->info('Users');
        $this->call('db:seed', [ '--class' => 'UsersTableSeeder']);
        $this->info('Roles-Users');
        $this->call('db:seed', [ '--class' => 'RoleUserTableSeeder']);
        $this->info('Settings');
        $this->call('db:seed', [ '--class' => 'SettingsTableSeeder']);
        $this->info('Done!');

        $this->line('Initialize settings values');
        Event::fire(new SettingsWereModified());
        $this->info('Done!');

    }
}
