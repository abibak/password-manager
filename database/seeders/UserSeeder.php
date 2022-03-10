<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $randomLength = rand(2, 20);

            User::insert([
                'role_id' => Role::where('access', 3)->get()->first()->id,
                'login' => Str::random($randomLength),
                'first_name' => '4343434.234234',
                'middle_name' => Str::random($randomLength),
                'last_name' => Str::random($randomLength),
                'email' => Str::random(8) . '@mail.ru',
                'master_password' => Hash::make('test'),
                'is_admin' => true,
                'is_blocked' => false,
            ]);
        }
    }
}
