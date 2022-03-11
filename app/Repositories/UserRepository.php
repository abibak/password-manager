<?php

namespace App\Repositories;

use App\Models\User as Model;

class UserRepository extends BaseRepository {

    public function getModelClass(): string
    {
        return Model::class;
    }

    public function getUserByEmail(string $email)
    {
        return $this->startCondition()->where('email', $email)->first();
    }
}
