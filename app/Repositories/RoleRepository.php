<?php


namespace App\Repositories;

use App\Models\Role as Model;

class RoleRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return Model::class;
    }

    public function getAllRoles()
    {
        return $this->startCondition()->get();
    }
}
