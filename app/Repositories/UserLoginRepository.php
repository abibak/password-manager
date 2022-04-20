<?php

namespace App\Repositories;

use App\Models\UserFolder;
use App\Models\UserLogin as Model;

class UserLoginRepository extends BaseRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getUserIdFromFolder(int $idFolder)
    {
        return UserFolder::select('user_id')->where('id', $idFolder)->first();
    }

    public function getDataLoginsByFolderId(int $idFolder)
    {
        return UserFolder::where('id', $idFolder)
            ->with('logins')
            ->get();
    }
}
