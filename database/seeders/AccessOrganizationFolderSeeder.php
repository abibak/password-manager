<?php

namespace Database\Seeders;

use App\Models\AccessOrganizationFolder;
use App\Models\OrganizationFolder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessOrganizationFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            AccessOrganizationFolder::insert([
                'organization_folder_id' => OrganizationFolder::all()->random()->id,
                'user_id' => User::all()->random()->id,
                'access' => '3',
            ]);
        }
    }
}
