<?php

namespace Database\Seeders;

use App\Models\AssignedRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignedRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssignedRole::insert([
            'user_id' => User::where('is_admin', 1)->first()->id,
            'role_id' => Role::where('name', 'Админы')->first()->id,
        ]);

        for ($i = 0; $i < 11; $i++) {
            AssignedRole::insert([
                'user_id' => User::where('is_admin', '!=', 1)->get()->random()->id,
                'role_id' => Role::where('name', 'Пользователи')->first()->id,
            ]);
        }
    }
}
