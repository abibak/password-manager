<?php

namespace App\Repositories;

use App\Models\OrganizationFolder as Model;

class OrganizationFolderRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return Model::class;
    }

    public function checkPermissions()
    {
        return $this->startCondition()->where('user_id', auth()->user()->id);
    }

    public function getDataFoldersWithLogins()
    {
        // папки созданные пользователем
        $userOrg = $this->startCondition()
            ->where('user_id', auth()->user()->id)
            ->with(['users', 'logins'])
            ->get();

        // папки с доступом
        $access = $this->startCondition()
            ->select('access_organization_folders.organization_folder_id as id',
                'organization_folders.user_id',
                'name',
                'status',
                'access'
            )->join('access_organization_folders', function ($join) {
                $join->on('access_organization_folders.organization_folder_id', '=', 'organization_folders.id')
                    ->where('access_organization_folders.user_id', '=', auth()->user()->id);
            })->with(['logins', 'users'])->get();

        if (count($userOrg)) {
            foreach ($userOrg as $folder) {
                $access[] = $folder;
            }
        }

        return $access;
    }

    public function getFolderUpdate(int $id)
    {
        return $this->checkPermissions()->where('id', $id)->first();
    }

    public function getFolderDelete(int $id)
    {
        return $this->checkPermissions()->where('id', $id)->first();
    }
}
