<?php

namespace Database\Seeders;

use App\Models\FolderHistory;
use App\Models\OrganizationFolder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FolderHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            FolderHistory::insert([
                'organization_folder_id' => OrganizationFolder::get()->random()->id,
                'user_login' => User::get()->random()->login,
                'action' => strtolower(Str::random(15)),
            ]);
        }
    }
}
