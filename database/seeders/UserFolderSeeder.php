<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserFolder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            UserFolder::insert([
                'user_id' => 1,
                'name' => Str::random(8),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            UserFolder::insert([
                'user_id' => User::where('id', '!=', 1)->get()->random()->id,
                'name' => Str::random(8),
            ]);
        }
    }
}
