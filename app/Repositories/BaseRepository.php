<?php

namespace App\Repositories;

abstract class BaseRepository {

    protected $model;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    abstract public function getModelClass();

    public function startCondition()
    {
        return clone $this->model;
    }

}
