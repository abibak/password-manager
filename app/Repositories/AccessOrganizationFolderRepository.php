<?php


namespace App\Repositories;


use App\Models\AccessOrganizationFolder as Model;


class AccessOrganizationFolderRepository extends BaseRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getAccessByFolderIdAndUserId(int $folderId, int $userId)
    {
        return $this->startCondition()->where('organization_folder_id', $folderId)->where('user_id', $userId)->first();
    }

    public function getAccessByUserId(int $idFolder)
    {
        return $this->startCondition()
            ->select('access')
            ->where('organization_folder_id', $idFolder)
            ->first();
    }
}
