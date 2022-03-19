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

    public function getDataLoginsByFolderId(int $idFolder)
    {
        return UserFolder::where('id', $idFolder)
            ->with('logins')
            ->get();
    }

    public function getDataLoginsByUserId()
    {
        return $this->startCondition()
            ->select(
                'user_folder_id',
                'user_logins.id as login_id',
                'user_folders.name as name_folder',
                'user_logins.name as name_login',
                'user_id',
                'login',
                'url',
                'tag',
                'note',
                'password',
            )
            ->leftJoin('user_folders', 'user_folders.id', '=', 'user_logins.user_folder_id')
            ->where('user_folders.user_id', auth()->user()->id)
            ->get();
    }
}
