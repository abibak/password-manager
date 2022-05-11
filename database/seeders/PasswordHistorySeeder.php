<?php

namespace Database\Seeders;

use App\Models\OrganizationLogin;
use App\Models\PasswordHistory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PasswordHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = ['open password', 'change password', 'delete password'];

        for ($i = 0; $i < 10; $i++) {
            PasswordHistory::insert([
                'login_id' => OrganizationLogin::get()->random()->id,
                'user_id' => User::get()->random()->id,
                'action_text' => $actions[rand(0, count($actions) - 1)],
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
