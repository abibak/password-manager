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
                'organization_folder_id' => $i,
                'user_id' => $i,
                'access' => '3',
            ]);
        }
    }
}
