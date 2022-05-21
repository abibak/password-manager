<?php

namespace App\Repositories;

use App\Models\FavoritePassword;
use App\Models\UserFolder;
use App\Models\UserLogin as Model;

class UserLoginRepository extends BaseRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getLoginById(int $id)
    {
        return $this->startCondition()->where('id', $id)->first();
    }

    public function getFavoritesPassword()
    {
        $favorites = [];
        $logins = FavoritePassword::select('user_id', 'user_login_id')
            ->where('user_id', auth()->user()->id)
            ->where('user_login_id', '!=', null)
            ->with('user_login')
            ->get();

        foreach ($logins as $login) {
            $favorites[] = $login->user_login;
        }

        return $favorites;
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

    public function getLoginByIdWithFolder(int $id)
    {
        return $this->startCondition()->where('id', $id)->with('folder')->first();
    }
}
