<?php

namespace App\Repositories;

use App\Models\OrganizationFolder as Model;
use App\Models\UserFolder;

class OrganizationLoginRepository extends BaseRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getUserIdFromFolder(int $idFolder)
    {
        return UserFolder::select('user_id')->where('id', $idFolder)->get();
    }
}
