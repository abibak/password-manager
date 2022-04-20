<?php

namespace App\Repositories;

use App\Models\OrganizationFolder;
use App\Models\OrganizationFolder as Model;

class OrganizationLoginRepository extends BaseRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getUserIdFromFolder(int $idFolder)
    {
        return OrganizationFolder::select('user_id')->where('id', $idFolder)->first();
    }
}
