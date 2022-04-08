<?php

namespace App\Repositories;

use App\Models\User as Model;

class UserRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return Model::class;
    }

    /*public function checkUser(int $userId, int $folderId)
    {
        $data = $this->startCondition()
            ->join('access_organization_folders', function ($join) use ($userId, $folderId) {
                $join->on('access_organization_folders.user_id', '=', 'users.id')
                    ->where('access_organization_folders.organization_folder_id', $folderId)
                    ->where('access_organization_folders.user_id', $userId);
            })->first();
    }*/

    public function getLogins()
    {
        return $this->startCondition()->select('id', 'login')->orderBy('id')->get();
    }

    /*public function getLogins(int $userId, int $folderId)
    {
        return $this->startCondition()
            ->join('access_organization_folders', function ($join) use ($userId, $folderId) {
                $join->on('access_organization_folders.user_id', '=', 'users.id')
                    ->where('access_organization_folders.organization_folder_id', $folderId)
                    ->where('access_organization_folders.user_id', $userId);
            })->first();

        // old worker variant
        // return $this->startCondition()->select('id', 'login')->orderBy('id')->get();
    }*/

    public function getUserByEmail(string $email)
    {
        return $this->startCondition()->where('email', $email)->first();
    }
}
