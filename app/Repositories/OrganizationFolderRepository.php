<?php

namespace App\Repositories;

use App\Models\OrganizationFolder as Model;

class OrganizationFolderRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return Model::class;
    }

    public function getDataFoldersWithLogins()
    {
        return $this->startCondition()
            ->join('access_organization_folders', function ($join) {
                $join->on('access_organization_folders.organization_folder_id', '=', 'organization_folders.id')
                    ->where('access_organization_folders.user_id', auth()->user()->id);
            })->with(['logins', 'users'])->get();
    }
}
