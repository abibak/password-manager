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
        User::insert([
            'login' => 'admin',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('admin'),
            'is_admin' => true,
            'is_blocked' => false,
        ]);

        for ($i = 0; $i < 10; $i++) {
            $randomLength = rand(2, 20);

            User::insert([
                'login' => Str::random($randomLength),
                'email' => Str::random(8) . '@mail.ru',
                'password' => Hash::make('test'),
                'is_admin' => false,
                'is_blocked' => false,
            ]);
        }
    }
}
