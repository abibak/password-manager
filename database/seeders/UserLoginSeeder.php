<?php

namespace Database\Seeders;

use App\Models\UserFolder;
use App\Models\UserLogin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class UserLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            UserLogin::insert([
                'user_folder_id' => UserFolder::where('user_id', 1)->get()->random()->id,
                'name' => Str::random(10),
                'login' => Str::random(6),
                'password' => Crypt::encryptString(Str::random(10)),
                'url' => 'example.com',
                'tags' => 'work,git',
                'note' => Crypt::encryptString('test_note' . $i),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            UserLogin::insert([
                'user_folder_id' => UserFolder::where('user_id', '!=', 1)->get()->random()->id,
                'name' => Str::random(10),
                'login' => Str::random(6),
                'password' => Crypt::encryptString(Str::random(10)),
                'url' => 'example.com',
                'tags' => 'social,IT,admin',
                'note' => Crypt::encryptString('test_note' . $i),
            ]);
        }
    }
}
