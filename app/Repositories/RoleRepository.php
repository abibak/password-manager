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

    public function getRoleById(int $id)
    {
        return $this->startCondition()->where('id', $id)->first();
    }
}
