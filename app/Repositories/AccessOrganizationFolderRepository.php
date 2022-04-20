<?php


namespace App\Repositories;


use App\Models\AccessOrganizationFolder as Model;


class AccessOrganizationFolderRepository extends BaseRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getAccessByUserId(int $idFolder)
    {
        return $this->startCondition()
            ->select('access')
            ->where('organization_folder_id', $idFolder)
            ->first();
    }
}
