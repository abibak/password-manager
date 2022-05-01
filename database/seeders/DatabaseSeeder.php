<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            AssignedRoleSeeder::class,
            UserFolderSeeder::class,
            UserLoginSeeder::class,
            OrganizationFolderSeeder::class,
            OrganizationLoginSeeder::class,
            AccessOrganizationFolderSeeder::class,
            FolderHistorySeeder::class,
        ]);
    }
}
