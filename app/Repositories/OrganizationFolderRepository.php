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

    }
}
