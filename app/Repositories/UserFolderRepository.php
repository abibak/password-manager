<?php

namespace App\Repositories;

use App\Models\UserFolder as Model;

class UserFolderRepository extends BaseRepository
{

    public function getModelClass(): string
    {
        return Model::class;
    }

    public function getDataFoldersWithLogins()
    {
        return $this->startCondition()->where('user_id', auth()->user()->id)->get();
    }

    public function getFolderById(int $folderId)
    {
        return $this->startCondition()->where([
            'id' => $folderId,
            'user_id' => auth()->user()->id
        ]);
    }

}
