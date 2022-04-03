<?php

namespace Database\Seeders;

use App\Models\OrganizationFolder;
use App\Models\OrganizationLogin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class OrganizationLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['socials', 'admins', 'work'];

        for ($i = 0; $i < 5; $i++) {
            OrganizationLogin::insert([
                'organization_folder_id' => OrganizationFolder::all()->random()->id,
                'name' => Str::random(10),
                'login' => Str::random(6),
                'password' => Crypt::encryptString(Str::random(10)),
                'url' => 'example.com',
                'tag' => collect($tags)->random(),
                'note' => Crypt::encryptString('test_note' . $i),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            OrganizationLogin::insert([
                'organization_folder_id' => OrganizationFolder::all()->random()->id,
                'name' => Str::random(10),
                'login' => Str::random(6),
                'password' => Crypt::encryptString(Str::random(10)),
                'url' => 'example.com',
                'tag' => collect($tags)->random(),
                'note' => Crypt::encryptString('test_note' . $i),
            ]);
        }
    }
}
