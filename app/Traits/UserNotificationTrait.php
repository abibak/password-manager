<?php

namespace App\Traits;

use App\Models\UserNotification;
use App\Repositories\OrganizationFolderRepository;

trait UserNotificationTrait
{
    public function writeAfterAddingToFolder($data)
    {
        $folderRepository = new OrganizationFolderRepository;

        if ($data->access === 3) {
            $accessText = 'с правами полного доступа';
        } else if ($data->access === 2) {
            $accessText = 'с правами редактирования';
        } else {
            $accessText = 'с правами просмотра содержимого';
        }

        UserNotification::create([
            'user_id' => $data->user_id,
            'notification_text' => 'Вы были добавлены в папку `' .
                $folderRepository->getFolderNameById($data->organization_folder_id)->name . '` ' . $accessText,
        ]);
    }

    public function writeAfterChangingPermissions($data)
    {
        $folderRepository = new OrganizationFolderRepository;

        UserNotification::create([
            'user_id' => $data->user_id,
            'notification_text' => 'Вам был изменен доступ в папке `' .
                $folderRepository->getFolderNameById($data->organization_folder_id)->name . '`',
        ]);
    }
}
