<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            'name' => 'admin',
            'access' => 3,
        ]);

        Role::insert([
            'name' => 'IT',
            'access' => 2,
        ]);
    }
}
