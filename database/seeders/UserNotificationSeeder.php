<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notificationText = [
            'Вы были удалены из папки \'Папка 1\'',
            'Вы были добавлены в папку \'Папка 2\'',
            'Были изменены права в \'Папка 3\''
        ];

        for ($i = 0; $i < 11; $i++) {
            UserNotification::create([
                'user_id' => User::get()->random()->id,
                'notification_text' => $notificationText[rand(0, count($notificationText) - 1)],
            ]);
        }
    }
}
