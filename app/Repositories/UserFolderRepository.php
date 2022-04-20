<?php

namespace App\Repositories;

use App\Models\UserFolder as Model;

class UserFolderRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return Model::class;
    }

    public function checkPermissions()
    {
        return $this->startCondition()->where('user_id', auth()->user()->id);
    }

    public function getDataFoldersWithLogins()
    {
        return $this->checkPermissions()->get();
    }

    public function getFolderById(int $id)
    {
        return $this->checkPermissions()->where('id', $id)->get();
    }

    public function getFolderUpdate(int $id)
    {
        return $this->checkPermissions()->where('id', $id)->first();
    }

    public function getFolderDelete(int $id)
    {
        return $this->checkPermissions()->where('id', $id)->first();
    }
}
